### **Le Workflow dans Symfony 7**

Le composant **Workflow** de Symfony permet de modéliser des processus métiers complexes en définissant des **états**, des **transitions**, et des **logiques conditionnelles**. Il est particulièrement utile pour gérer des flux tels que des systèmes de validation, des pipelines de traitement ou des étapes de processus (ex. : commandes, publications d'articles, etc.).

---

### **1. Concepts Clés**

1. **Sujet (Subject)** : L'objet sur lequel le workflow s'applique.
2. **Places** : Les différents **états** dans lesquels un sujet peut se trouver.
3. **Transitions** : Les **actions** ou **changements** qui permettent de passer d’un état à un autre.
4. **Marquage (Marking)** : Représentation de l'état actuel du sujet dans le workflow.
5. **Guards (Gardiens)** : Des conditions qui doivent être remplies pour qu'une transition soit possible.
6. **Événements** : Des hooks permettant d'exécuter des actions pendant une transition.

---

### **2. Installation et Configuration**

#### **Installation**
Ajoutez le composant Workflow à votre projet :
```bash
composer require symfony/workflow
```

#### **Configuration**
Dans le fichier `config/packages/workflow.yaml`, configurez votre workflow. Voici un exemple de workflow pour un article de blog :

```yaml
framework:
    workflows:
        article_workflow: # Nom du workflow
            type: 'state_machine' # Peut être 'workflow' ou 'state_machine'
            marking_store:
                type: 'single_state' # Permet un seul état à la fois
            supports:
                - App\Entity\Article # Classe sur laquelle le workflow s'applique
            places: # États possibles
                - draft
                - review
                - published
            transitions: # Définition des transitions
                to_review:
                    from: draft
                    to: review
                publish:
                    from: review
                    to: published
```

---

### **3. Utilisation dans le Code**

#### **Définir une entité**
Créez une entité qui représentera le sujet du workflow.

```php
namespace App\Entity;

class Article
{
    private string $currentState = 'draft'; // État initial

    public function getCurrentState(): string
    {
        return $this->currentState;
    }

    public function setCurrentState(string $state): void
    {
        $this->currentState = $state;
    }
}
```

#### **Injecter le service Workflow**
Le service Workflow est utilisé pour manipuler les transitions et états.

```php
namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\Workflow\WorkflowInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    public function index(WorkflowInterface $articleWorkflow): Response
    {
        $article = new Article();

        // Vérifier les transitions possibles
        $transitions = $articleWorkflow->getEnabledTransitions($article);
        foreach ($transitions as $transition) {
            echo $transition->getName(); // Affiche "to_review"
        }

        // Appliquer une transition
        if ($articleWorkflow->can($article, 'to_review')) {
            $articleWorkflow->apply($article, 'to_review');
        }

        return new Response('Workflow exécuté');
    }
}
```

---

### **4. Types de Workflows**

1. **Workflow** :
   - Permet à un sujet d’être dans plusieurs états simultanément.
   - Exemple : Un article peut être en cours de rédaction et en cours de révision.

2. **State Machine** :
   - Le sujet ne peut être que dans un seul état à la fois.
   - Exemple : Un système de validation d'une commande (créée, en attente de validation, expédiée).

---

### **5. Guards (Conditions)**

Les guards permettent de définir des conditions pour qu'une transition soit possible.

#### Exemple avec des guards :
```yaml
framework:
    workflows:
        article_workflow:
            transitions:
                to_review:
                    from: draft
                    to: review
                    guard: "is_granted('ROLE_EDITOR')"
```

Dans cet exemple, la transition `to_review` ne peut être effectuée que par un utilisateur ayant le rôle `ROLE_EDITOR`.

---

### **6. Événements**

Vous pouvez écouter des événements pour exécuter des actions avant ou après une transition.

#### Exemple d'écouteur d'événements :
```php
namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\CompletedEvent;
use Symfony\Component\Workflow\Event\GuardEvent;

class WorkflowSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'workflow.article_workflow.guard.to_review' => 'onGuardToReview',
            'workflow.article_workflow.completed.to_review' => 'onCompletedToReview',
        ];
    }

    public function onGuardToReview(GuardEvent $event): void
    {
        // Bloquer la transition si une condition n'est pas remplie
        $subject = $event->getSubject(); // L'objet lié au workflow
        if ($subject instanceof Article && $subject->getCurrentState() !== 'draft') {
            $event->setBlocked(true);
        }
    }

    public function onCompletedToReview(CompletedEvent $event): void
    {
        // Action après une transition
        $subject = $event->getSubject();
        // Par exemple, envoyer une notification
    }
}
```

---

### **7. Visualisation du Workflow**

Symfony offre une intégration avec Graphviz pour visualiser votre workflow.

#### Installation de Graphviz :
```bash
sudo apt install graphviz # Linux
brew install graphviz     # macOS
choco install graphviz    # Windows
```

#### Générer un graphe :
Ajoutez ceci à un contrôleur ou une commande :
```php
use Symfony\Component\Workflow\Dumper\GraphvizDumper;

$dumper = new GraphvizDumper();
echo $dumper->dump($workflow->getDefinition());
```

Ensuite, utilisez Graphviz pour convertir ce graphe en image :
```bash
php bin/console workflow:dump article_workflow | dot -Tpng -o workflow.png
```

---

### **8. Exemple Complet**

#### Workflow YAML :
```yaml
framework:
    workflows:
        order_workflow:
            type: 'state_machine'
            marking_store:
                type: 'single_state'
            supports:
                - App\Entity\Order
            places:
                - created
                - pending
                - shipped
                - delivered
            transitions:
                to_pending:
                    from: created
                    to: pending
                to_shipped:
                    from: pending
                    to: shipped
                to_delivered:
                    from: shipped
                    to: delivered
```

#### Entité Order :
```php
namespace App\Entity;

class Order
{
    private string $currentState = 'created';

    public function getCurrentState(): string
    {
        return $this->currentState;
    }

    public function setCurrentState(string $state): void
    {
        $this->currentState = $state;
    }
}
```

#### Utilisation :
```php
$order = new Order();
$orderWorkflow->apply($order, 'to_pending');
```

---

### **9. Bonnes Pratiques**

1. **Modularité** : Gardez vos workflows simples et spécifiques.
2. **Tests** : Testez les conditions et transitions pour éviter des bugs.
3. **Documentation** : Documentez vos workflows pour les rendre compréhensibles.
4. **Événements** : Utilisez les événements pour des tâches comme la journalisation ou les notifications.

---

Le composant Workflow de Symfony 7 est un outil puissant pour modéliser des processus complexes de manière lisible et maintenable. Si vous avez besoin d'exemples pratiques ou d'une explication sur un cas spécifique, faites-le-moi savoir !