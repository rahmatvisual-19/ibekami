/**
 * convert-to-webp.js
 * Converts all existing JPG/PNG images in Laravel storage to WebP.
 * Updates filenames in-place (renames file, keeps original as backup).
 *
 * Usage:
 *   node scripts/convert-to-webp.js [--dry-run] [--no-backup] [--quality=80]
 *
 * Options:
 *   --dry-run    Show what would be converted without doing it
 *   --no-backup  Delete original files after conversion (default: keep as .bak)
 *   --quality=N  WebP quality 1-100 (default: 80)
 */

const sharp = require('sharp');
const fs    = require('fs');
const path  = require('path');

// ─── Config ──────────────────────────────────────────────────────────────────

const args      = process.argv.slice(2);
const DRY_RUN   = args.includes('--dry-run');
const NO_BACKUP = args.includes('--no-backup');
const QUALITY   = parseInt((args.find(a => a.startsWith('--quality=')) || '--quality=80').split('=')[1]);

const STORAGE_ROOT = path.join(__dirname, '..', 'storage', 'app', 'public');
const IMAGE_EXTS   = ['.jpg', '.jpeg', '.png'];

// ─── Helpers ─────────────────────────────────────────────────────────────────

function walkDir(dir) {
    let results = [];
    if (!fs.existsSync(dir)) return results;
    for (const entry of fs.readdirSync(dir, { withFileTypes: true })) {
        const full = path.join(dir, entry.name);
        if (entry.isDirectory()) {
            results = results.concat(walkDir(full));
        } else if (IMAGE_EXTS.includes(path.extname(entry.name).toLowerCase())) {
            results.push(full);
        }
    }
    return results;
}

function formatBytes(bytes) {
    return (bytes / 1024).toFixed(1) + ' KB';
}

// ─── Main ─────────────────────────────────────────────────────────────────────

async function main() {
    const files = walkDir(STORAGE_ROOT);

    if (files.length === 0) {
        console.log('✅ No JPG/PNG files found — nothing to convert.');
        return;
    }

    console.log(`\n🔍 Found ${files.length} image(s) to convert (quality: ${QUALITY}%)`);
    if (DRY_RUN) console.log('   [DRY RUN — no files will be changed]\n');

    let converted = 0, skipped = 0, failed = 0;
    let savedBytes = 0;

    for (const srcPath of files) {
        const ext     = path.extname(srcPath).toLowerCase();
        const webpPath = srcPath.slice(0, -ext.length) + '.webp';
        const relPath  = path.relative(STORAGE_ROOT, srcPath);

        // Skip if WebP already exists
        if (fs.existsSync(webpPath)) {
            console.log(`  ⏭  SKIP  ${relPath} (webp already exists)`);
            skipped++;
            continue;
        }

        if (DRY_RUN) {
            console.log(`  🔄 WOULD CONVERT  ${relPath}`);
            converted++;
            continue;
        }

        try {
            const srcSize = fs.statSync(srcPath).size;
            await sharp(srcPath)
                .webp({ quality: QUALITY })
                .toFile(webpPath);
            const dstSize = fs.statSync(webpPath).size;
            savedBytes += (srcSize - dstSize);

            if (NO_BACKUP) {
                fs.unlinkSync(srcPath);
                console.log(`  ✅ CONVERTED  ${relPath}  (${formatBytes(srcSize)} → ${formatBytes(dstSize)}, deleted original)`);
            } else {
                fs.renameSync(srcPath, srcPath + '.bak');
                console.log(`  ✅ CONVERTED  ${relPath}  (${formatBytes(srcSize)} → ${formatBytes(dstSize)}, original → .bak)`);
            }
            converted++;
        } catch (err) {
            console.error(`  ❌ FAILED   ${relPath}: ${err.message}`);
            // Clean up partial webp if it exists
            if (fs.existsSync(webpPath)) fs.unlinkSync(webpPath);
            failed++;
        }
    }

    console.log(`\n📊 Summary:`);
    console.log(`   Converted : ${converted}`);
    console.log(`   Skipped   : ${skipped}`);
    console.log(`   Failed    : ${failed}`);
    if (!DRY_RUN && savedBytes !== 0) {
        console.log(`   Space saved: ${formatBytes(savedBytes)}`);
    }
    console.log('');

    if (converted > 0 && !DRY_RUN) {
        console.log('⚠️  IMPORTANT: Run the Laravel migration command to update database records:');
        console.log('   php artisan images:update-db-to-webp\n');
    }
}

main().catch(err => {
    console.error('Fatal error:', err);
    process.exit(1);
});
