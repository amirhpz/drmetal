import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import fs from 'node:fs';
import path from 'node:path';

function normalizeLaravelManifest() {
    return {
        name: 'normalize-laravel-manifest',
        closeBundle() {
            const manifestPath = path.resolve(process.cwd(), 'public/build/manifest.json');

            if (!fs.existsSync(manifestPath)) {
                return;
            }

            const manifest = JSON.parse(fs.readFileSync(manifestPath, 'utf8'));
            const normalized = {};

            for (const [key, value] of Object.entries(manifest)) {
                const normalizedKey = normalizeManifestPath(key);
                const entry = { ...value };

                if (typeof entry.src === 'string') {
                    entry.src = normalizeManifestPath(entry.src);
                }

                normalized[normalizedKey] = entry;
            }

            fs.writeFileSync(manifestPath, `${JSON.stringify(normalized, null, 2)}\n`);
        },
    };
}

function normalizeManifestPath(manifestPath) {
    const relativePath = path.relative(process.cwd(), manifestPath).replaceAll('\\', '/');

    if (!relativePath.startsWith('..') && !path.isAbsolute(relativePath)) {
        return relativePath;
    }

    return manifestPath.replaceAll('\\', '/');
}

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/panel.js'],
            refresh: true,
        }),
        tailwindcss(),
        normalizeLaravelManifest(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
