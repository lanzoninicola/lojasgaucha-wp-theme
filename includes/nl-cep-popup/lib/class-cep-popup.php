<?php



class CEP_Popup
{

    private array $user_stories_models = [];

    private string $current_story_name;

    private string $first_story_name = "";

    private string $last_story_name = "";

    public function __construct(...$args)
    {
        // var_dump($args[0]["user_stories_data"]);die();

        $this->setup(
            $args[0]["user_stories_data"],
            $args[0]["configs"]
        );
    }

    public function setup(array $userstories_data, array $configs)
    {
        foreach ($userstories_data as $user_story_data) {
            array_push($this->user_stories_models, new CEP_Popup_Userstory($user_story_data));
        }

        $this->first_story_name = $configs["first_userstory_name"];
        $this->last_story_name = $configs["last_userstory_name"];

        $this->init_current_story_name();
    }


    public function show_content()
    {
        $user_stories_models_filtered = array_filter($this->user_stories_models, function ($user_story_model) {
            if ($user_story_model->has_name($this->current_story_name)) {
                return $user_story_model;
            }
        });

        $user_story_model = $user_stories_models_filtered[0];

        if ("page" === $user_story_model->get_type()) {
            include $user_story_model->get_file_part();
        }
    }

    public function next_content()
    {

        echo "non so miaaaaaaaaaa";
    }

    public function get_stories()
    {
        return $this->user_stories;
    }

    public function get_current_story_name()
    {
        return $this->current_story_name;
    }

    public function init_current_story_name()
    {
        if (!isset($this->current_story_name)) {
            $this->current_story_name = $this->first_story_name;
        }
    }

    public function set_current_story_name(string $story_name)
    {
        $this->current_story_name = $story_name;
    }
}
