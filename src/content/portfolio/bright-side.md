---
title: "Bright✦Side"
description: "A small good-news website that follows the light of the moon. Intentions aligning with growth, appreciation, celebration, and reflection."
completed: 2026-11-18
categories: [react-typescript, live-site, design-mockups ] 
featured: true
heroImage: "@portfolio/bright-side.png"
heroAlt: "The Bright✦Side home page at the first quarter moon with the growth hero present"

slides:
  - title: Context & Inspiration✦
    content: |
      For a while, I had grown tired of the doom scrolling, the constant anxiety about the future, and the promotion of negativity both in the online space and in the real world. Cities don't feel like communities, towns don't feel like villages, policies aren't improving, and the globe is changing faster than we can prepare for. I don't want to see the world as doomed, I want to prove good still exists. That's the spark as to why I decided to create Bright✦Side. I want to make a difference, no matter how small.

      I wanted the site itself to feel alive, so I tied it to something that changes slowly and predictably: the moon. I love connecting intentions and energy to the moon, attuning to her energy to daily life released tension and anxiety I had with the world around me. I wanted to bring that same feeling and intention with the core of this site. From the design, to the sounds, to the voice, everything about Bright✦Side inspires hope, optimism, positivity, and gratitude. The voices behind Bright✦Side were hand picked by me, and stories tailored to the messages that I think need to be spread the most.
    images:
      - src: "@portfolio/bright-side-inspo.png"
        alt: "The overall moodboard I had prior to starting. Focusing on real, human art, florals, and the moon."
  - title: Process✦
    content: |
      I started in Figma, as that's what I knew best. I wanted to get the general look and feel down before stepping into the code, so I had something to referance later on. I knew early on I wanted to use Tailwind, so I tried to find the Tailwind CSS classes that I would need and designed with them in mind. I also wanted to change up the icon set I typically used, and went with[Phosphor Icons](https://phosphoricons.com/). I really liked the options for outline and duotone specifically. I created Figma components for the repeatable interactive elements, designed logos and moon vectors, and I got far enough along that I knew the visual direction I was wanting to go.

      As for what I wanted to build it with, I really wanted to immerse myself in React and Next.js as well as Tailwind CSS to really understand the framework. It was challenging working in a differnet framework, but I really enjoyed it. I especially liked the flexibility Tailwind offered. I could mix global theme styles with element specific ones. It saved me a lot of custom CSS.
    images:
      - src: "@portfolio/bright-side-ui.png"
        alt: "The designed UI guide I referenced throughout development"
      - src: "@portfolio/bright-side-components.png"
        alt: "The designed repeatable components I referenced throughout development"
  - title: Revolving Around The Moon✦
    content: |
      The hero message changes with the lunar cycle, as she moves around us, we follow her and resonate in her light. The site moves through **growth** (waxing moon), **celebrate** (the full moon), **appreciation** (waning moon), and **reflection** (new moon), with **rejoice** reserved for a Blue Moon and **deeply reflect** arriving with Lunar Eclipses. The nebula background of the hero is pure css, which I'm pretty proud of.
      
      Each phase has a featured feed attached to it, sharing articles and videos aligning with the focus of that phase. While waxing to waning moons feature positive, feel good stories, reflection can feature more somber, serious stories that still need to be addressed. The whole idea is that darkness can't exist without light, and light always returns after darkness. Setbacks happen, and it's important to acknowledge both, though at expected predictable times.
    images:
      - src: "@portfolio/bright-side-growth.png"
        alt: "The home page hero during the growth phase"
      - src: "@portfolio/bright-side-celebrate.png"
        alt: "The home page hero during the full moon, focusing on celebration"
      - src: "@portfolio/bright-side-appreciate.png"
        alt: "The home page hero during the appreciation phase"
      - src: "@portfolio/bright-side-reflect.png"
        alt: "The home page hero during the new moon, focusing on reflection"

  - title: Curating the Feed✦
    content: |
      Bright✦Side pulls from good-news RSS feeds and embedded YouTube channels, including Sam Bentley, Planet Wild and The Ocean Cleanup. Every post gets one or two categories, the home page shows the latest ten, and a paginated news archive holds the rest. The categories and tone are added based on the keywords found in the article's title and content. It's not perfect, so a manual overide exists if needed. In the end, I decided to only link to the external articles, as I wanted to be as careful as possible to avoid copyright or republishing issues.

      The editorial rules are part of the design:
      - Somber stories only appear at the new moon or during an eclipse, and sensitive ones are tagged up front so no one is caught off guard.
      - Everything else stays purely good news. No AI related stories, even the good ones.
      - Partisan politics stays out, unless a story is positive action that doesn't add anxiety.
    images:
      - src: "@portfolio/bright-side-news.png"
        alt: "Desktop layout of the good news page with all the categories"
  - title: Additional & Stretch Goals✦
    content: |
      During production, I had an idea to create a small player that adds chill lofi while you're visiting. Though, I needed to make sure it was lisensed to use and I did not want AI music to be added. The current playlists are fetched through the Jamendo API, before 2022, and the playlists also fetch songs matching the current site tone. Each moon event gets its own playlist, so the sound matches the mood of the sky.

      What's next for Bright✦Side? Well, I intend to add more atmospheric sound preferances (like ocean waves, rain, crickets, etc.). As well, a toggle for reduced motion, a light theme following the sun instead. The solar theme would offer a dawn, midday, afternoon, and twilight theme, applied based on the client's timezone. Solstices, eclipses, and equinoxes would be special themes. The tones would still be aligned with the moon, but the hero and site theme would be the one changing.
    # images:
    #   - src: "@portfolio/bright-side-placeholder.png"
    #     alt: "what do i put here?-"

links:
  site: https://brightsidemoon.vercel.app/
  figma:
    url: https://www.figma.com/design/0BTq9sakhwBtI33YXEW7SL/Bright-Side?node-id=0-1&t=jI7gjbkoaYn37ONb-1
    type: design
  github: https://github.com/KokoTheNekoGirl/bright-side
---

**Roles:** Designer & Developer

**Stack:** Figma, Next.js 16, React 19, TypeScript, Tailwind CSS v4, astronomy-engine, rss-parser, Jamendo API, Phosphor Icons, Vercel

**Coming Soon:** Umami analytics/privacy, footer rebuild, solar light theme switcher