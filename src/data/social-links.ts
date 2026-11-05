/* Single source for my social links. */
import { CaraLogo, ToyhouseLogo, ArtfightLogo } from '@assets';
import type { ImageMetadata } from 'astro';
import { KOFI_URL } from '@data/commissions';

interface SocialLink {
  name: string;
  url: string;
  category: 'primary' | 'secondary';
  icon?: string;
  image?: ImageMetadata;
}

export const socialLinks: SocialLink[] = [
  {
    name: 'Discord',
    url: 'https://discordapp.com/users/289194094431961089',
    category: 'primary',
    icon: 'fa-discord'
  },
  {
    name: 'Bluesky',
    url: 'https://bsky.app/profile/kokoneko.art',
    category: 'primary',
    icon: 'fa-bluesky'
  },
  {
    name: 'Cara',
    url: 'https://cara.app/kokonekoart',
    category: 'primary',
    image: CaraLogo
  },
  {
    name: 'GitHub',
    url: 'https://github.com/KokoTheNekoGirl',
    category: 'secondary',
    icon: 'fa-github'
  },
  {
    name: 'YouTube',
    url: 'https://youtube.com/@KokoTheNekoGirl',
    category: 'secondary',
    icon: 'fa-youtube'
  },
  {
    name: 'Toyhouse',
    url: 'https://toyhou.se/KokoNekoArt',
    category: 'secondary',
    image: ToyhouseLogo
  },
  {
    name: 'ArtFight',
    url: 'https://artfight.net/~KokoNekoArt',
    category: 'secondary',
    image: ArtfightLogo
  },
  {
    name: 'Kofi',
    url: KOFI_URL,
    category: 'secondary',
    icon: 'fa-ko-fi'
  },
];