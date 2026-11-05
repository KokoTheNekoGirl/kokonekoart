import type { ImageMetadata } from 'astro';

export const ART_TYPES = {
  headshot: 'Headshot Sample',
  bust: 'Bust Sample',
  halfbody: 'Halfbody Sample',
  fullbody: 'Fullbody Sample',
  chibi: 'Chibi Sample',
  scene: 'Fullbody Scene',
} as const;

export type ArtType = keyof typeof ART_TYPES;

export type SampleArt = {
  src: ImageMetadata;
  type: ArtType;
  label: string;
  alt: string;
};

// Filename convention: [NN-]<type>--<anything>.<ext>
//   halfbody--art-sample.png        -> "Halfbody Sample"
//   03-chibi--art-sample.png        -> "Chibi Sample", and the 03 pins its position
const FILENAME = /^(?:(\d+)-)?([a-z]+)--(.+)$/;

const files = import.meta.glob<{ default: ImageMetadata }>(
  '/src/assets/art/*.{png,jpg,jpeg,webp,avif}',
  { eager: true },
);

export function getSampleArt(): SampleArt[] {
  return Object.entries(files)
    .map(([path, mod]) => {
      const file = path.split('/').pop()!;
      const base = file.replace(/\.[^.]+$/, '');
      const match = FILENAME.exec(base);
      if (!match || !(match[2] in ART_TYPES)) {
        throw new Error(
          `Sample art "${file}" must be named [NN-]<type>--<name>.ext with type one of: ${Object.keys(ART_TYPES).join(', ')}`,
        );
      }
      const type = match[2] as ArtType;
      const label = ART_TYPES[type];
      return { file, src: mod.default, type, label, alt: `${label} art example` };
    })
    // Numeric prefixes sort first (01, 02, ...), everything else alphabetically.
    .sort((a, b) => a.file.localeCompare(b.file, undefined, { numeric: true }))
    .map(({ file, ...art }) => art);
}