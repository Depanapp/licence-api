<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titre', 'Administration') — Licences</title>
    <style>
        :root {
            --fond: #F5F6F8;
            --surface: #FFFFFF;
            --bordure: #E4E6EA;
            --texte: #1E2126;
            --texte-secondaire: #6B7280;
            --accent: #2F6FED;
            --danger: #DC2626;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--fond);
            color: var(--texte);
            line-height: 1.5;
        }

        /* HEADER RESPONSIVE */
        header {
            background: #14181F;
            color: white;
            padding: 16px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap; /* Permet le passage à la ligne sur mobile */
        }

        header .marque { 
            font-weight: 700; 
            font-size: 16px; 
            letter-spacing: .3px; 
        }

        header nav { 
            display: flex; 
            align-items: center; 
            gap: 16px;
            flex-wrap: wrap;
        }

        header nav a {
            color: #C7CBD1;
            text-decoration: none;
            font-size: 13.5px;
            transition: color 0.2s;
        }

        header nav a:hover { color: white; }

        header form { margin: 0; }

        header form button {
            background: transparent;
            border: 1px solid #3A4150;
            color: #C7CBD1;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12.5px;
            cursor: pointer;
            transition: all 0.2s;
        }

        header form button:hover {
            border-color: #C7CBD1;
            color: white;
        }

        /* MAIN CONTENEUR */
        main { 
            max-width: 1080px; 
            margin: 0 auto; 
            padding: 28px; 
        }

        h1 { font-size: 20px; margin: 0 0 4px; }
        .sous-titre { color: var(--texte-secondaire); font-size: 13px; margin: 0 0 24px; }

        /* CARTES ET ALERTES */
        .carte {
            background: var(--surface);
            border: 1px solid var(--bordure);
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .alerte-succes {
            background: #ECFDF5;
            border: 1px solid #A7F3D0;
            color: #065F46;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13.5px;
            margin-bottom: 20px;
        }

        .alerte-erreur {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            color: #991B1B;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13.5px;
            margin-bottom: 20px;
        }

        /* CONTENEUR DE TABLEAU RESPONSIVE */
        .table-container {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            font-size: 13.5px; 
            white-space: nowrap; /* Empêche le texte du tableau de trop se compresser */
        }

        th, td { text-align: left; padding: 10px 12px; border-bottom: 1px solid var(--bordure); }
        th { color: var(--texte-secondaire); font-weight: 600; font-size: 11.5px; text-transform: uppercase; letter-spacing: .4px; }
        tr:hover td { background: #FAFAFA; }

        /* BADGES ET BOUTONS */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .badge-active { background: #ECFDF5; color: #16A34A; }
        .badge-expiree { background: #FEF3C7; color: #B45309; }
        .badge-bloquee { background: #FEF2F2; color: #DC2626; }

        .bouton {
            display: inline-block;
            background: var(--accent);
            color: white;
            padding: 10px 16px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-align: center;
        }

        .bouton-secondaire {
            background: var(--surface);
            color: var(--texte);
            border: 1px solid var(--bordure);
        }

        .bouton-danger { background: var(--danger); }

        /* FORMULAIRES */
        label { display: block; font-size: 12.5px; font-weight: 600; color: var(--texte-secondaire); margin: 14px 0 6px; }
        
        input, select {
            width: 100%;
            padding: 10px 12px;
            border-radius: 9px;
            border: 1px solid var(--bordure);
            font-size: 13.5px;
            background: #FAFAFA;
        }

        .grille-2 { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 0 16px; 
        }

        .cle-licence {
            font-family: 'SF Mono', Consolas, monospace;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 1px;
            background: #F4F4F1;
            padding: 10px 14px;
            border-radius: 8px;
            display: inline-block;
            word-break: break-all;
        }

        /* MEDIA QUERIES POUR MOBILE */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                align-items: flex-start;
                padding: 16px;
            }

            header nav {
                width: 100%;
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            header form {
                width: 100%;
            }

            header form button {
                width: 100%;
            }

            main {
                padding: 16px;
            }

            .carte {
                padding: 16px;
            }

            .grille-2 {
                grid-template-columns: 1fr; /* Bascule sur une seule colonne */
            }

            .bouton {
                width: 100%; /* Boutons pleine largeur pour plus d'accessibilité au toucher */
            }
        }
    </style>
</head>
<body>
    @auth
    <header>
        <div class="marque">Administration — Licences</div>
        <nav>
            <a href="{{ route('admin.dashboard') }}">Licences</a>
            <a href="{{ route('admin.entreprises.create') }}">Nouvelle entreprise</a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit">Se déconnecter</button>
            </form>
        </nav>
    </header>
    @endauth

    <main>
        @if (session('succes'))
            <div class="alerte-succes">{{ session('succes') }}</div>
        @endif

        @if(session('success'))
            <div class="alerte-succes">
                {{ session('success') }}
            </div>
        @endif

        @if(session('erreur'))
            <div class="alerte-erreur">
                {{ session('erreur') }}
            </div>
        @endif

        @yield('contenu')
    </main>

    @stack('scripts')
</body>
</html>