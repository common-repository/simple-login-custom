=== Simple Login Custom ===
Stable Tag: 1.6.0
Requires at least: 4.0
Tested up to: 6.6.2
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Un plugin facile pour personnaliser les formulaires de connexion et d'enregistrement via shortcodes dans WordPress.

== Description ==

**Simple Login Custom** est un plugin simple qui permet de créer un système de connexion et d'enregistrement personnalisé, entièrement géré via des shortcodes. Idéal pour les besoins de personnalisation basiques !

**Key Features:**

- **Formulaire de Connexion Personnalisé:** Personnalisez l'apparence de votre formulaire de connexion en toute simplicité.
- **Lien de Connexion Personnalisé:** Ajoutez un lien personnalisé vers votre page de connexion n'importe où sur votre site avec un shortcode.
- **Personnalisation de Style:** Ajustez les couleurs, largeurs et styles directement depuis les réglages WordPress.
- **Contrôle des Derniers Connexions:** À partir de la version 1.5.0, suivez les dix dernières connexions pour un suivi de sécurité amélioré.
- **Gestion de l'Enregistrement Intégré:** Les utilisateurs peuvent s'enregistrer directement via le même formulaire de connexion.

**How It Works:**

- Accédez à **Réglages > Custom Login Settings** dans votre tableau de bord WordPress pour personnaliser votre formulaire de connexion et votre lien.
- Utilisez le shortcode `[customlogin_form]` pour afficher votre formulaire de connexion personnalisé sur n'importe quelle page.
- Utilisez le shortcode `[customlogin_link]` pour créer un lien personnalisé vers le formulaire de connexion avec votre texte préféré.

**Installation:**

1. Téléchargez les fichiers du plugin dans le répertoire `/wp-content/plugins/`.
2. Activez le plugin via le menu 'Plugins' dans WordPress.

**Settings:**

- Accédez aux options de personnalisation via **Réglages > Custom Login Settings**. Ici, vous pouvez ajuster le style du formulaire, configurer le texte personnalisé pour votre lien de connexion et examiner les dernières tentatives de connexion.

== Screenshots ==

1. **Formulaire de Connexion Personnalisé:** Aperçu du formulaire de connexion modifié.
2. **Paramètres de Personnalisation:** Interface des réglages pour personnaliser les options de connexion et d'enregistrement.
3. **Contrôle des Derniers Connexions:** Interface montrant les dix dernières connexions enregistrées.

== Changelog ==

= 1.6.0 =
- **Ajout:** Fonctionnalité de gestion de l'enregistrement intégrée au formulaire de connexion.
- **Amélioration:** Amélioration de l'interface utilisateur pour une meilleure expérience.

= 1.5.0 =
- **Nouvelle Fonctionnalité:** Ajout d'un système de contrôle pour les dix dernières connexions, améliorant la surveillance de l'activité des utilisateurs et la sécurité.
- **Simplification:** Amélioration de l'interface de style pour faciliter la personnalisation de l'esthétique du formulaire de connexion.

= 1.0.1 =
- **Support Multilingue:** Ajout de fichiers de traduction pour une accessibilité accrue.

== FAQ ==

### Comment puis-je personnaliser le style du formulaire de connexion ?

Vous pouvez accéder à **Réglages > Custom Login Settings** dans votre tableau de bord WordPress pour ajuster les couleurs, les largeurs et le style du formulaire de connexion.

### Qu'est-ce que le contrôle des dix derniers logins ?

Depuis la version 1.5.0, notre plugin propose une nouvelle fonctionnalité permettant de surveiller les dix dernières connexions à votre site. Cela aide à renforcer la sécurité en vous permettant de garder un œil sur les activités de connexion.

### Puis-je utiliser ce plugin avec d'autres plugins de sécurité ?

Oui, **Simple Login Custom** est conçu pour fonctionner en harmonie avec d'autres plugins de sécurité. Assurez-vous simplement que les plugins n'entrent pas en conflit pour les mêmes fonctionnalités.

### Comment insérer le formulaire de connexion dans une page ?

Utilisez le shortcode `[customlogin_form]` dans l'éditeur de page ou de billet où vous souhaitez afficher le formulaire de connexion personnalisé.

### La personnalisation affecte-t-elle la sécurité du formulaire de connexion ?

Non, toute personnalisation du style ne modifie pas la sécurité intrinsèque du processus de connexion, qui reste conforme aux meilleures pratiques de sécurité WordPress.

### Puis-je changer le texte du lien de connexion ?

Absolument ! Dans les réglages du plugin, vous pouvez modifier le texte qui apparaîtra comme lien vers votre formulaire de connexion personnalisé.

### Comment puis-je signaler un bug ou proposer une nouvelle fonctionnalité ?

Vous pouvez nous contacter via les réglages du plugin ou en ouvrant un ticket sur notre repository GitHub. Nous apprécions toute contribution et suggestion pour améliorer **Simple Login Custom**.

== Plugins Recommandés ==

Pour améliorer l'expérience utilisateur et l'ergonomie de votre site, voici des plugins que nous recommandons pour leur synergie avec **Simple Login Custom** :

- **Page Scroll to ID** : Ce plugin est parfait pour créer une navigation fluide et intuitive sur votre site. Il permet aux utilisateurs de cliquer sur des liens pour faire défiler la page jusqu'à un élément spécifique, ce qui est idéal pour des pages à contenu étendu ou des sites à une seule page. La compatibilité avec **Simple Login Custom** assure que même après un login ou un redirect, les utilisateurs peuvent toujours naviguer efficacement.

- **LoginWP (Formerly Peter's Login Redirect)** : Conçu pour gérer les redirections après la connexion ou la déconnexion, **LoginWP** est essentiel pour personnaliser l'expérience de login. Vous pouvez rediriger les utilisateurs vers différentes pages selon leurs rôles, capacités, ou même des règles spécifiques. Cela renforce la sécurité en empêchant l'accès non autorisé à des sections du site et s'intègre parfaitement avec **Simple Login Custom** pour offrir une expérience de connexion fluide et sécurisée.

**Pourquoi ces plugins ?**

- **Facilité d'Utilisation :** Les deux plugins sont connus pour leur interface intuitive et leur facilité d'intégration avec WordPress, rendant la personnalisation accessible même aux utilisateurs sans connaissance approfondie en développement.

- **Amélioration de l'Expérience Utilisateur :** **Page Scroll to ID** améliore la navigation sur votre site et assure une expérience utilisateur optimale.
