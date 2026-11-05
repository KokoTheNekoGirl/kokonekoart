// @ts-check

import mdx from '@astrojs/mdx';
import sitemap from '@astrojs/sitemap';
import AutoImport from 'unplugin-auto-import/astro';
import { defineConfig, fontProviders } from 'astro/config';

import react from '@astrojs/react';

export default defineConfig({
    site: 'https://kokoneko.art',
    trailingSlash: 'never',
    integrations: [mdx(), sitemap(), react(),
        AutoImport({
            imports: [{
                './src/components/ButtonLink.astro': [
                ['default', 'ButtonLink']
                ],
                './src/components/IconLink.astro': [
                ['default', 'IconLink']
                ]
            }]
        })
    ],
    fonts: [
        {
            provider: fontProviders.local(),
            name: 'Spinnaker',
            cssVariable: '--font-spinnaker',
            fallbacks: ['sans-serif'],
            options: {
                variants: [
                    {
                        src: ['./src/assets/fonts/Spinnaker-Regular.woff2'],
                        weight: 400,
                        style: 'normal',
                        display: 'swap',
                    },
                ],
            },
        },
        {
            provider: fontProviders.local(),
            name: 'Fuzzy Bubbles',
            cssVariable: '--font-fuzzy-bubbles',
            fallbacks: ['cursive'],
            options: {
                variants: [
                    {
                        src: ['./src/assets/fonts/FuzzyBubbles-Regular.woff2'],
                        weight: 400,
                        style: 'normal',
                        display: 'swap',
                    },
                                        {
                        src: ['./src/assets/fonts/FuzzyBubbles-Bold.woff2'],
                        weight: 700,
                        style: 'normal',
                        display: 'swap',
                    },
                ],
            },
        },
    ],
});