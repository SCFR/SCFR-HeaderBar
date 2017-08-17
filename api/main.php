<?php namespace SCFR\HeaderBar\api;

class Main {
    
    /** custom pages we want to get the links for */
    protected $pagesNeedLink = [
        "Recrutement",
        "categories",
        "star citizen",
        "Community Hub",
        "Partenaires",
        "L'Equipe",
        "Recrutement",
        "Guide des nouveaux",
        "Guide des touches du clavier",
        "Version",
        "F.A.Q",
    ];

    protected $categoriesNeedLink = [
        3,6,7
    ];
    
    /** our HeaderBar model */
    protected $bar;
    
    public function __construct() {
        $this->bar = new \SCFR\HeaderBar\model\HeaderBar();
        add_action( 'rest_api_init', array(&$this, 'routes') );
    }
    
    public function routes() {
        $namespace = 'HeaderBar';
        
        register_rest_route( $namespace, '/Full/', array(
        'methods' => 'GET',
        'callback' => array( &$this, 'getFullHeader' ),
        ) );
        
        
    }
    
    public function getFullHeader() {
        $this->fetchPagesLinks();
        $this->fetchNewsCats();
        return $this->bar;
    }
    
    protected function fetchPagesLinks() {
        foreach($this->pagesNeedLink as $page) {
            $link = get_permalink(get_page_by_title($page)->ID);
            if($link) $this->bar->links[$page] = $link;
        }
    }
    
    
    protected function fetchNewsCats() {
        $this->bar->news = ["categories" =>  $this->fetchCategoryList()];
    }
    
    protected function fetchCategoryList() {
        $cats = [];
        foreach($this->categoriesNeedLink as $cat_id) {
            $cats[] = $this->header_display_categories_list($cat_id);
        }

        return $cats;
    }

    protected function header_display_categories_list($cat_id) {
        $args       = array('orderby' => 'count', 'parent' => $cat_id, 'order' => 'desc', 'number' => 8);
        $categories = get_categories($args);
        
        $cat = [
            "name" => get_cat_name($cat_id),
            "link" => get_category_link($cat_id),
            "sub" => [],
        ];
        
        foreach ($categories as $category) {
            $cat["sub"][] = ["name" =>  $category->name, "link" => get_category_link($category->term_id)];
        }

        return $cat;
    }
    
    
}