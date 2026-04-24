/**
 * convert-videos-to-webm.cjs
 * Converts all MP4/OGG videos in storage/app/public/banner_picture to WebM (VP9).
 *
 * Usage:
 *   node scripts/convert-videos-to-webm.cjs [--dry-run] [--no-backup]
 */

const ffmpeg   = require('fluent-ffmpeg');
const ffmpegBin = require('@ffmpeg-installer/ffmpeg');
const path     = require('path');
const fs       = require('fs');

ffmpeg.setFfmpegPath(ffmpegBin.path);

const args      = process.argv.slice(2);
const DRY_RUN   = args.includes('--dry-run');
const NO_BACKUP = args.includes('--no-backup');

const STORAGE_DIR = path.join(__dirname, '..', 'storage', 'app', 'public', 'banner_picture');
const VIDEO_EXTS  = ['.mp4', '.ogg', '.mov'];

function walkDir(dir) {
    if (!fs.existsSync(dir)) return [];
    return fs.readdirSync(dir, { withFileTypes: true })
        .filter(e => e.isFile() && VIDEO_EXTS.includes(path.extname(e.name).toLowerCase()))
        .map(e => path.join(dir, e.name));
}

function formatMB(bytes) {
    return (bytes / 1024 / 1024).toFixed(2) + ' MB';
}

function convertToWebM(srcPath) {
    return new Promise(function (resolve, reject) {
        const ext     = path.extname(srcPath);
        const webmPath = srcPath.slice(0, -ext.length) + '.webm';

        ffmpeg(srcPath)
            .videoCodec('libvpx-vp9')
            .audioCodec('libopus')
            .outputOptions([
                '-crf 40',        // kualitas (lebih tinggi = lebih kecil, 40 bagus untuk web)
                '-b:v 0',         // bitrate mode: CRF only
                '-vf scale=720:-2', // scale down ke 720p
                '-b:a 64k',       // audio bitrate
                '-deadline good', // encoding speed vs quality tradeoff
                '-cpu-used 4',    // 0=slowest/best, 5=fastest
                '-row-mt 1',      // multi-thread row encoding
            ])
            .output(webmPath)
            .on('end', function () { resolve(webmPath); })
            .on('error', function (err) { reject(err); })
            .run();
    });
}

async function main() {
    const files = walkDir(STORAGE_DIR);

    if (files.length === 0) {
        console.log('✅ No MP4/OGG videos found in banner_picture — nothing to convert.');
        return;
    }

    console.log(`\n🎬 Found ${files.length} video(s) to convert`);
    if (DRY_RUN) console.log('   [DRY RUN — no files will be changed]\n');

    let converted = 0, skipped = 0, failed = 0;
    let savedBytes = 0;

    for (const srcPath of files) {
        const ext      = path.extname(srcPath);
        const webmPath = srcPath.slice(0, -ext.length) + '.webm';
        const relPath  = path.relative(STORAGE_DIR, srcPath);

        if (fs.existsSync(webmPath)) {
            console.log(`  ⏭  SKIP  ${relPath} (webm already exists)`);
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
            console.log(`  🔄 Converting  ${relPath}  (${formatMB(srcSize)}) ...`);

            await convertToWebM(srcPath);

            const dstSize = fs.statSync(webmPath).size;
            savedBytes += (srcSize - dstSize);

            if (NO_BACKUP) {
                fs.unlinkSync(srcPath);
                console.log(`  ✅ Done  → ${path.basename(webmPath)}  (${formatMB(dstSize)}, original deleted)`);
            } else {
                fs.renameSync(srcPath, srcPath + '.bak');
                console.log(`  ✅ Done  → ${path.basename(webmPath)}  (${formatMB(dstSize)}, original → .bak)`);
            }
            converted++;
        } catch (err) {
            console.error(`  ❌ FAILED  ${relPath}: ${err.message}`);
            if (fs.existsSync(webmPath)) fs.unlinkSync(webmPath);
            failed++;
        }
    }

    console.log(`\n📊 Summary:`);
    console.log(`   Converted : ${converted}`);
    console.log(`   Skipped   : ${skipped}`);
    console.log(`   Failed    : ${failed}`);
    if (!DRY_RUN && savedBytes > 0) {
        console.log(`   Space saved: ${formatMB(savedBytes)}`);
    }

    if (converted > 0 && !DRY_RUN) {
        console.log('\n⚠️  Run the Laravel command to update database records:');
        console.log('   php artisan videos:update-db-to-webm\n');
    }
}

main().catch(function (err) {
    console.error('Fatal:', err);
    process.exit(1);
});
