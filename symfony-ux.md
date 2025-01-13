### **Symfony UX dans Symfony 7 : Une Explication Complète**

**Symfony UX** est une initiative de Symfony qui vise à rapprocher le développement **frontend** et **backend**, en facilitant l’intégration d’outils JavaScript modernes dans les applications Symfony. Il repose sur des principes de **progressive enhancement**, où le JavaScript améliore l’expérience utilisateur sans complexifier inutilement votre projet.

Symfony UX a été introduit avec Symfony 5.3 et reste entièrement compatible avec Symfony 7.

---

### **1. Les Objectifs de Symfony UX**
Symfony UX facilite :
- **L’intégration d’outils modernes** comme Stimulus, Webpack Encore, et Turbo.
- **La création de composants interactifs** sans écrire de JavaScript complexe.
- **L’automatisation des workflows** pour inclure des librairies front-end (charts, éditeurs de texte riche, carrousels, etc.).
- **Une expérience utilisateur optimisée** grâce à l’enrichissement progressif des fonctionnalités.

---

### **2. Les Composants Clés de Symfony UX**

#### **A. Stimulus**
Stimulus est un framework JavaScript léger conçu pour travailler en harmonie avec votre HTML. Il permet de rendre vos applications interactives en associant des contrôleurs JavaScript à des éléments HTML via des attributs `data-*`.

**Exemple :**
```html
<button data-controller="hello" data-action="click->hello#greet">
    Cliquez-moi !
</button>
```

```javascript
// assets/controllers/hello_controller.js
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    greet() {
        alert('Bonjour depuis Symfony UX avec Stimulus !');
    }
}
```

---

#### **B. Turbo**
Turbo (issu du projet Hotwire) remplace la navigation complète des pages par une navigation "turbo", où seules les parties pertinentes de la page sont mises à jour. Cela permet des **performances améliorées** et une **expérience utilisateur fluide**, sans nécessiter un framework JavaScript complet comme React ou Vue.js.

---

#### **C. Webpack Encore**
Symfony UX repose sur **Webpack Encore** pour gérer les assets (JavaScript, CSS, images, etc.) de manière efficace. Cela inclut la compilation, la minification et la gestion des dépendances npm.

Commandes associées :
```bash
composer require symfony/webpack-encore-bundle
yarn install
```

---

#### **D. Packages Symfony UX**
Symfony UX propose une série de packages préconfigurés pour des fonctionnalités courantes :
- **symfony/ux-chartjs** : Intégration de graphiques avec Chart.js.
- **symfony/ux-twig-component** : Composants Twig dynamiques.
- **symfony/ux-dropzone** : Upload de fichiers avec une interface glisser-déposer.
- **symfony/ux-swup** : Transitions fluides entre les pages.

Exemple d’installation d’un package UX :
```bash
composer require symfony/ux-chartjs
yarn install
yarn dev
```

---

### **3. Exemple Pratique : Intégration d’un Graphique avec UX Chart.js**

#### **A. Installation**
1. Installez le package UX Chart.js :
   ```bash
   composer require symfony/ux-chartjs
   yarn install
   yarn dev
   ```

2. Symfony ajoute automatiquement les fichiers nécessaires dans vos assets.

#### **B. Utilisation dans un Template**
Ajoutez un composant graphique dans un fichier Twig :
```twig
<div id="my-chart" data-controller="chart" data-chart-data="{{ chart_data|json_encode }}"></div>
```

#### **C. Stimulus Controller pour Chart.js**
Créez un fichier `chart_controller.js` dans le dossier `assets/controllers` :
```javascript
import { Controller } from '@hotwired/stimulus';
import Chart from 'chart.js/auto';

export default class extends Controller {
    connect() {
        const data = JSON.parse(this.element.dataset.chartData);

        new Chart(this.element, {
            type: 'bar',
            data: data,
        });
    }
}
```

#### **D. Données Backend**
Générez les données dans votre contrôleur Symfony :
```php
public function chart(): Response
{
    $chartData = [
        'labels' => ['Janvier', 'Février', 'Mars'],
        'datasets' => [
            [
                'label' => 'Ventes',
                'backgroundColor' => ['red', 'blue', 'green'],
                'data' => [100, 200, 300],
            ],
        ],
    ];

    return $this->render('chart.html.twig', [
        'chart_data' => $chartData,
    ]);
}
```

---

### **4. Installation et Configuration Symfony UX**

#### A. Installer Symfony UX
Si Symfony UX n’est pas encore configuré dans votre projet, commencez par installer le package principal :
```bash
composer require symfony/ux
yarn install
yarn dev
```

#### B. Vérifier l’installation
Vérifiez que les fichiers JavaScript sont bien générés dans le répertoire `public/build`.

#### C. Configurer Webpack Encore
Le fichier `webpack.config.js` contient la configuration principale de Webpack Encore. Exemple minimal :
```javascript
const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.js')
    .enableStimulusBridge('./assets/controllers.json')
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction());

module.exports = Encore.getWebpackConfig();
```

---

### **5. Pourquoi Utiliser Symfony UX ?**

- **Facilité d’utilisation :** Vous travaillez principalement avec HTML et ajoutez du JavaScript seulement si nécessaire.
- **Interopérabilité :** Compatible avec les outils modernes (React, Vue.js, Tailwind, etc.) mais fonctionne parfaitement seul.
- **Amélioration progressive :** Pas besoin de migrer entièrement à un framework JavaScript pour ajouter des fonctionnalités dynamiques.
- **Gain de productivité :** Les packages Symfony UX simplifient l’intégration d’éléments interactifs comme des graphiques, des carrousels, ou des transitions.

---

### **6. Cas d’utilisation Courants**

- Créer des interfaces interactives pour des formulaires, des graphiques ou des carrousels.
- Optimiser les performances avec Turbo pour éviter les rechargements de pages complets.
- Simplifier l’enrichissement progressif de votre frontend.

---

### **7. Avantages dans Symfony 7**
Symfony 7 continue de renforcer l'intégration de Symfony UX, notamment avec une meilleure prise en charge de Stimulus, Turbo, et des composants Twig, offrant ainsi une expérience plus fluide et moderne pour les développeurs.

---

Si vous voulez un exemple détaillé sur un package spécifique ou une démonstration approfondie, dites-le-moi ! 😊