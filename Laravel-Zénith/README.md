# Template Dashboard Digit All

## Présentation
Ce projet est un template complet et professionnel pour un dashboard d’entreprise, conçu pour **Digit All**. Il est basé sur :
- **Laravel 12** (backend)
- **Livewire 3** (composants dynamiques)
- **Tailwind CSS v3** (design moderne, palette custom)
- **Alpine.js** (interactivité légère)

Le code est ultra clean, structuré, abondamment commenté et pensé pour la maintenabilité et l’évolutivité.

---

## Structure du projet

```
├── app/
│   └── Livewire/           # Composants Livewire (Dashboard, Users, Stats, Settings, Notification)
├── resources/
│   ├── views/
│   │   ├── layouts/        # Layout principal (sidebar, header, slot contenu)
│   │   ├── livewire/       # Vues des composants Livewire
│   │   └── errors/         # Pages d’erreur custom (404)
│   └── css/app.css         # Configuration Tailwind + styles custom Digit All
├── routes/web.php          # Définition des routes principales
└── app/Exceptions/Handler.php # Gestion des erreurs (404 custom)
```

---

## Palette Digit All
- **Orange** : `#FFA726`
- **Bleu nuit** : `#1A1333`
- **Blanc** : `#FFFFFF`
- **Light** : `#F8F9FB`

Utilisée partout pour garantir l’identité visuelle.

---

## Navigation et pages
- `/` : **Dashboard** (widgets, graphique, notification)
- `/utilisateurs` : **Utilisateurs** (tableau dynamique, recherche, pagination)
- `/statistiques` : **Statistiques** (KPIs, graphique)
- `/parametres` : **Paramètres** (profil, préférences)
- Routes inconnues : **404 custom** (design Digit All, animation)

La sidebar permet une navigation fluide, avec surbrillance dynamique et icônes modernes.

---

## Ajouter une page ou un composant
1. **Créer le composant Livewire**
   ```bash
   php artisan make:livewire NomDuComposant
   ```
2. **Créer la route dans `routes/web.php`**
   ```php
   Route::get('/votre-url', \App\Livewire\NomDuComposant::class)->name('nom-route');
   ```
3. **Ajouter le lien dans la sidebar** (avec icône et surbrillance dynamique)
4. **Respecter la palette et le design Digit All**
5. **Commenter chaque section pour la clarté**

---

## Bonnes pratiques et conventions
- Toujours utiliser la palette Digit All
- Code ultra commenté et structuré
- Ne jamais utiliser les templates de base Laravel/Livewire/Tailwind sans personnalisation
- Préférer les composants réutilisables (ex : Notification)
- Responsive, animations, accessibilité
- Utiliser les classes utilitaires Tailwind pour la cohérence

---

## Crédits et conseils
- Ce template est prêt à accueillir l’authentification, la gestion des rôles, et les vraies données (modèles, migrations, etc.)
- Pour toute évolution : garder la philosophie clean code, commenter, tester chaque fonctionnalité
- Inspiré par les meilleures pratiques Laravel, Livewire et Tailwind

---

**Projet réalisé pour Digit All – Design unique, expérience utilisateur moderne, code prêt pour l’avenir !**

- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
