<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pokédex</title>

    <style>

        :root {
            --bg: #08090d;
            --surface: #151720;
            --border: #252832;
            --text: #ffffff;
            --muted: #a3a7b2;
            --accent: #ff3b30;

            --feu: #ff7a2f;
            --electrik: #ffd23f;
            --plante: #5fd068;
            --eau: #4aa8ff;
            --psy: #c06bff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100dvh;
        }

        .skip-link {
            position: absolute;
            left: 16px;
            top: -60px;
            background: var(--accent);
            color: var(--text);
            padding: 10px 16px;
            border-radius: 8px;
            z-index: 100;
        }

        .skip-link:focus {
            top: 16px;
        }


        /* HEADER */

        header {
            position: fixed;
            inset: 0 0 auto 0;
            z-index: 50;
            padding: 24px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(to bottom, rgba(8, 9, 13, 0.85), transparent);
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .logo span {
            color: var(--accent);
        }

        .badge {
            background: rgba(21, 23, 31, 0.7);
            border: 1px solid #292c36;
            padding: 10px 16px;
            border-radius: 50px;
            color: var(--muted);
            font-size: 14px;
            backdrop-filter: blur(8px);
        }


        /* SCROLL VIDEO */

        .scrolly {
            position: relative;
            /* 1 écran par Pokémon + 1 écran de marge pour finir sur Mewtwo */
            height: calc(var(--count) * 100vh + 100vh);
        }

        .scrolly-stage {
            position: sticky;
            top: 0;
            height: 100vh;
            height: 100dvh;
            overflow: hidden;
        }

        .scrolly-video {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .scrolly-stage::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(to right, rgba(8, 9, 13, 0.92) 0%, rgba(8, 9, 13, 0.55) 38%, transparent 65%),
                linear-gradient(to top, rgba(8, 9, 13, 0.9), transparent 30%);
            pointer-events: none;
        }


        /* FICHE POKEMON */

        .fiche {
            position: absolute;
            z-index: 2;
            left: 7%;
            top: 50%;
            width: min(420px, 86%);
            transform: translateY(calc(-50% + 24px));
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-out, transform 0.3s ease-out, visibility 0.3s;
        }

        .fiche.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(-50%);
        }

        .fiche-numero {
            color: var(--muted);
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 2px;
            font-variant-numeric: tabular-nums;
        }

        .fiche h2 {
            font-size: clamp(44px, 6vw, 72px);
            font-weight: 800;
            letter-spacing: -2px;
            line-height: 1.05;
            margin: 6px 0 16px;
            color: var(--type);
        }

        .fiche-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }

        .type {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--type);
            border: 1px solid var(--type);
            background: rgba(0, 0, 0, 0.35);
        }

        .fiche p {
            color: #d4d7de;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 22px;
        }

        .fiche h3 {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--muted);
            margin-bottom: 10px;
        }

        .pouvoirs {
            list-style: none;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 22px;
        }

        .pouvoirs li {
            background: rgba(21, 23, 32, 0.75);
            border: 1px solid var(--border);
            border-left: 3px solid var(--type);
            padding: 10px 12px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: bold;
        }

        .stats {
            display: grid;
            gap: 8px;
        }

        .stat {
            display: grid;
            grid-template-columns: 72px 1fr 36px;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: var(--muted);
        }

        .stat-value {
            text-align: right;
            color: var(--text);
            font-weight: bold;
            font-variant-numeric: tabular-nums;
        }

        .stat-bar {
            height: 6px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            overflow: hidden;
        }

        .stat-bar span {
            display: block;
            height: 100%;
            background: var(--type);
            border-radius: 6px;
            transform-origin: left;
        }

        .feu { --type: var(--feu); }
        .electrik { --type: var(--electrik); }
        .plante { --type: var(--plante); }
        .eau { --type: var(--eau); }
        .psy { --type: var(--psy); }


        /* RARETE */

        .rarete {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .commun {
            background: rgba(148, 163, 184, 0.18);
            color: #cbd5e1;
            border: 1px solid rgba(148, 163, 184, 0.35);
        }

        .rare {
            background: rgba(59, 130, 246, 0.18);
            color: #93c5fd;
            border: 1px solid rgba(59, 130, 246, 0.4);
        }

        .tres-rare {
            background: rgba(168, 85, 247, 0.18);
            color: #d8b4fe;
            border: 1px solid rgba(168, 85, 247, 0.4);
        }

        .legendaire {
            background: rgba(245, 158, 11, 0.18);
            color: #fcd34d;
            border: 1px solid rgba(245, 158, 11, 0.4);
        }


        /* NAVIGATION POINTS */

        .dots {
            position: absolute;
            z-index: 3;
            right: 4%;
            top: 50%;
            transform: translateY(-50%);
            list-style: none;
            display: grid;
            gap: 4px;
        }

        .dots button {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            background: none;
            border: none;
            cursor: pointer;
            touch-action: manipulation;
        }

        .dots button span {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.35);
            transition: transform 0.2s ease-out, background 0.2s ease-out;
        }

        .dots button[aria-current="true"] span {
            background: var(--text);
            transform: scale(1.5);
        }

        .dots button:focus-visible,
        .skip-link:focus-visible {
            outline: 3px solid var(--text);
            outline-offset: 2px;
            border-radius: 50%;
        }

        .scroll-hint {
            position: absolute;
            z-index: 2;
            bottom: 28px;
            left: 50%;
            transform: translateX(-50%);
            color: var(--muted);
            font-size: 13px;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: opacity 0.3s ease-out;
        }


        /* GRILLE RECAP */

        .container {
            width: 86%;
            max-width: 1200px;
            margin: auto;
            padding: 80px 0;
        }

        .container > h2 {
            font-size: 32px;
            margin-bottom: 30px;
        }

        .pokemon-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .pokemon-card {
            background: linear-gradient(145deg, var(--surface), #0e1016);
            border: 1px solid var(--border);
            border-top: 3px solid var(--accent);
            border-radius: 20px;
            padding: 24px;
        }

        .pokemon-card .fiche-numero {
            margin-bottom: 8px;
        }

        .pokemon-card h3 {
            font-size: 22px;
            margin-bottom: 6px;
        }

        .pokemon-card .type-label {
            color: var(--type);
            font-size: 14px;
            margin-bottom: 16px;
        }

        .vide {
            color: var(--muted);
        }

        .capture-image {
            display: block;
            width: 120px;
            height: 120px;
            object-fit: contain;
            margin: 8px auto 16px;
        }

        .shiny {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #fcd34d;
            border: 1px solid rgba(245, 158, 11, 0.4);
            border-radius: 50px;
            padding: 3px 8px;
            vertical-align: middle;
        }

        .infos {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 14px;
        }

        .infos dt {
            font-size: 12px;
            color: var(--muted);
        }

        .infos dd {
            font-weight: bold;
            font-variant-numeric: tabular-nums;
        }

        footer {
            border-top: 1px solid #1c1e26;
            padding: 30px;
            text-align: center;
            color: #8a8e99;
            font-size: 14px;
        }


        /* MOBILE */

        @media (max-width: 768px) {

            header {
                padding: 16px;
            }

            .scrolly-stage::after {
                background: linear-gradient(to top, rgba(8, 9, 13, 0.97) 0%, rgba(8, 9, 13, 0.85) 45%, transparent 75%);
            }

            .fiche {
                left: 16px;
                right: 16px;
                width: auto;
                top: auto;
                bottom: 24px;
                transform: translateY(24px);
            }

            .fiche.active {
                transform: translateY(0);
            }

            .fiche h2 {
                margin: 4px 0 10px;
            }

            .fiche p {
                font-size: 15px;
                margin-bottom: 14px;
            }

            .stats {
                display: none;
            }

            .pouvoirs {
                margin-bottom: 0;
            }

            .pouvoirs li {
                padding: 8px 10px;
                font-size: 13px;
            }

            .dots {
                right: 4px;
                top: 30%;
            }

            .scroll-hint {
                display: none;
            }

            .container {
                width: auto;
                margin: 0 16px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .fiche,
            .dots button span,
            .scroll-hint {
                transition: none;
            }
        }

    </style>
</head>


<body>

<a class="skip-link" href="#recap">Passer au récapitulatif</a>

<header>

    <div class="logo">
        Poké<span>Dex</span>
    </div>

    <div class="badge">
        {{ count($pokemon) }} Pokémon
    </div>

</header>


<main>

    <section class="scrolly" style="--count: {{ count($pokemon) }}" aria-label="Présentation des Pokémon">

        <div class="scrolly-stage">

            <video
                class="scrolly-video"
                src="{{ asset('videos/pokemon-scroll.mp4') }}"
                poster="{{ asset('videos/pokemon-poster.jpg') }}"
                muted
                playsinline
                preload="auto"
                aria-hidden="true"
            ></video>

            @foreach ($pokemon as $index => $p)

                <article class="fiche {{ $p['couleur'] }} {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}" aria-hidden="{{ $index === 0 ? 'false' : 'true' }}">

                    <div class="fiche-numero">
                        N° {{ str_pad($p['numero'], 3, '0', STR_PAD_LEFT) }}
                    </div>

                    <h2>{{ $p['nom'] }}</h2>

                    <div class="fiche-tags">
                        <span class="type">{{ $p['type'] }}</span>
                        <span class="rarete {{ Str::slug($p['rarete']) }}">{{ $p['rarete'] }}</span>
                    </div>

                    <p>{{ $p['description'] }}</p>

                    <h3>Pouvoirs</h3>

                    <ul class="pouvoirs">
                        @foreach ($p['pouvoirs'] as $pouvoir)
                            <li>{{ $pouvoir }}</li>
                        @endforeach
                    </ul>

                    <div class="stats">
                        @foreach ($p['stats'] as $label => $valeur)
                            <div class="stat">
                                <span>{{ $label }}</span>
                                <div class="stat-bar" role="presentation">
                                    <span style="transform: scaleX({{ min($valeur / 150, 1) }})"></span>
                                </div>
                                <span class="stat-value">{{ $valeur }}</span>
                            </div>
                        @endforeach
                    </div>

                </article>

            @endforeach

            <ul class="dots">
                @foreach ($pokemon as $index => $p)
                    <li>
                        <button type="button" data-index="{{ $index }}" aria-label="Aller à {{ $p['nom'] }}" @if ($index === 0) aria-current="true" @endif>
                            <span></span>
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="scroll-hint">Scrollez</div>

        </div>

    </section>


    <section class="container" id="recap" tabindex="-1">

        <h2>Récapitulatif</h2>

        @if ($captures->isEmpty())

            <p class="vide">Aucun Pokémon dans la base de données pour l'instant.</p>

        @else

            <div class="pokemon-container">

                @foreach ($captures as $c)

                    <div class="pokemon-card">

                        <div class="fiche-numero">
                            N° {{ str_pad($c->id, 3, '0', STR_PAD_LEFT) }}
                        </div>

                        <img
                            class="capture-image"
                            src="{{ $c->image }}"
                            alt="{{ $c->name }}"
                            width="120"
                            height="120"
                            loading="lazy"
                            onerror="this.style.visibility='hidden'"
                        >

                        <h3>
                            {{ $c->name }}
                            @if ($c->is_shiny)
                                <span class="shiny">Shiny</span>
                            @endif
                        </h3>

                        <dl class="infos">
                            <div><dt>Niveau</dt><dd>{{ $c->level }}</dd></div>
                            <div><dt>PV</dt><dd>{{ $c->life }}</dd></div>
                            <div><dt>Taille</dt><dd>{{ $c->height }} m</dd></div>
                            <div><dt>Poids</dt><dd>{{ $c->weight }} kg</dd></div>
                            <div><dt>Genre</dt><dd>{{ $c->genre ? 'Mâle' : 'Femelle' }}</dd></div>
                            <div><dt>Capturé le</dt><dd>{{ \Carbon\Carbon::parse($c->captured_at)->format('d/m/Y') }}</dd></div>
                        </dl>

                    </div>

                @endforeach

            </div>

        @endif

    </section>

</main>


<footer>

    PokéDex — Projet Laravel

</footer>


<script>
    (function () {
        const section = document.querySelector('.scrolly');
        const video = section.querySelector('.scrolly-video');
        const fiches = section.querySelectorAll('.fiche');
        const dots = section.querySelectorAll('.dots button');
        const hint = section.querySelector('.scroll-hint');
        const count = fiches.length;
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        let target = 0;
        let current = 0;
        let activeIndex = 0;

        // Progression du scroll dans la section, de 0 à 1
        function progress() {
            const rect = section.getBoundingClientRect();
            const distance = section.offsetHeight - window.innerHeight;
            return Math.min(Math.max(-rect.top / distance, 0), 1);
        }

        function setActive(index) {
            if (index === activeIndex) return;
            activeIndex = index;
            fiches.forEach((fiche, i) => {
                fiche.classList.toggle('active', i === index);
                fiche.setAttribute('aria-hidden', i === index ? 'false' : 'true');
            });
            dots.forEach((dot, i) => {
                if (i === index) dot.setAttribute('aria-current', 'true');
                else dot.removeAttribute('aria-current');
            });
        }

        function onScroll() {
            const p = progress();
            target = p;
            setActive(Math.min(Math.floor(p * count), count - 1));
            hint.style.opacity = p > 0.02 ? 0 : 1;
        }

        // Lissage pour que la vidéo suive le scroll sans à-coups
        function tick() {
            current += (target - current) * (reduceMotion ? 1 : 0.15);
            if (video.duration) {
                const time = current * (video.duration - 0.05);
                if (Math.abs(video.currentTime - time) > 0.01) {
                    video.currentTime = time;
                }
            }
            requestAnimationFrame(tick);
        }

        dots.forEach((dot) => {
            dot.addEventListener('click', () => {
                const index = Number(dot.dataset.index);
                const distance = section.offsetHeight - window.innerHeight;
                window.scrollTo({
                    top: section.offsetTop + ((index + 0.5) / count) * distance,
                    behavior: reduceMotion ? 'auto' : 'smooth',
                });
            });
        });

        // Vidéo chargée en mémoire : elle devient "seekable" même si le
        // serveur (ex : php artisan serve) ne gère pas les requêtes Range
        fetch(video.src)
            .then((response) => response.blob())
            .then((blob) => { video.src = URL.createObjectURL(blob); })
            .catch(() => {});

        window.addEventListener('scroll', onScroll, { passive: true });
        video.addEventListener('loadedmetadata', onScroll);
        onScroll();
        requestAnimationFrame(tick);
    })();
</script>

</body>

</html>
