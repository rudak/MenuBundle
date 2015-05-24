# MenuBundle
Simple Bundle de gestion des menus


## Installation
**Composer.json** :```"rudak/menu-bundle": "dev-master"```    
**Kernel** : ```new Rudak\MenuBundle\RudakMenuBundle()```

## Utilisation

Il faut commencer par configurer les items du menu, dans config.yml de cette facon :
    
    rudak_menu:
        items:
            - { index: Accueil, route: homepage, title: 'Accueil du site' }
            - { index: Administration, route: main_admin, title: 'Administration du site' }
            
Ensuite il faut placer l'appel du controller ```{{ render(controller('RudakMenuBundle:Include:getHtmlMenu')) }}``` dans votre vue sensée afficher le menu, chez moi c'est un menu *bootstrap classique* qui se trouve dans ```'::main-menu.html.twig'```. Par contre le menu ne renvoie que les elements LI vu qu'il y a plein de classes dans mon UL, ca va plus vite. On peut forcer l'envoie d'un UL contenant l'ID ```main_menu``` enveloppant tout ca en ajoutant le parametre **wrapper = true** a l'appel du controller, dans le Twig. Par défaut, le wrapper est False. 

Voila à quoi ce Twig ressemble :
    
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse"
                        class="navbar-toggle collapsed" type="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="#" class="navbar-brand">
                    MonSite.fr
                </a>
            </div>
            <div class="navbar-collapse collapse" id="navbar">
                <ul class="nav navbar-nav">
                    {{ render(controller('RudakMenuBundle:Include:getHtmlMenu')) }}
                </ul>    
            </div>
            <!--/.nav-collapse -->
        </div>
        <!--/.container-fluid -->
    </nav>

## Fonctionnement

Voila, le menu sera appelé tout seul a chaque affichage, de votre page, maintenant il faut signaler sur quelle page on se trouve pour que l'onglet correspondant prenne la classe 'active'. C'est pas obligatoire mais c'est quand meme mieux. Pour faire ca, je fais appel a un service qui va coller le nom de la route actuelle en session, dans chaque controlleur. Mais avant ca, je récupère **le nom de la route en cour** en rajoutant un argument spécial dans ma methode de controller. Cet argument, c'est ```$_route```. Donc voila le service a appeler pour mettre a jour la page sur laquelle on se trouve avec un petit exemple de controlleur basique :

    	public function indexAction($_route)
    	{
    		$MenuUpdater = $this->get('rudak.menu.updater');
    		$MenuUpdater->update($_route);
    		return $this->render('GameMainBundle:Default:index.html.twig');
    	}
    	
*Alors... J'imagine qu'on peut trouver mieux pour identifier les pages, mais je sais pas trop comment alors ca évoluera peut etre mais pour l'instant ca marche pas trop mal comme ca donc ^^... (TODO)*

## Hierarchie

Sur un de mes sites, la partie blog et ses articles me posaient probleme. Je voulais que mes articles dépendent de l'onglet blog (onglet actif). Pour cette raison j'ai créé un systeme de hierarchie, configurable dans ```config.yml``` comme ceci :

    rudak_menu:
        items:
            // ......
        hierachy:
            monBlog: ['mon_article','liste_articles_full']
            papa: ['fils','fille','chien','chat']

C'est assez simple à comprendre et ca correspond mieux à ce que je voulais. Comme ca, si on a un onglet actualités par exemple, il sera actif aussi bien pour la liste des actus que pour les actus elles memes. Ca peut etre arrangé encore...

    