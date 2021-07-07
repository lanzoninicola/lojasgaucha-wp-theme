<?php

class CEP_Popup_Userstory {
    
    private array $story;

    private string $name = "";

    private string $type = "";

    private string $include = "";

    private array $options = [];

    public function __construct(array $story_data) {
        $this->story = $story_data;
        $this->name = $story_data["name"];
        $this->type = $story_data["type"];
        $this->include = $story_data["include"];
        $this->options = $story_data["options"];
	}

    public function get_full_story(){
        return $this->story;
    }

    public function has_name($name){
        if($name === $this->name) {
            return true;
        }

        return false;
    }

    public function get_name(){
        return $this->name;
    }

    public function get_type(){
        return $this->type;
    }

    public function get_file_part(){
        $partial_path = get_stylesheet_directory();

        return $partial_path . $this->include;
    }

    public function has_nr_options(){
        return count($this->options);
    }

    public function next_action_is(int $optionNumber){
        if(is_numeric($optionNumber) and !is_null($optionNumber)){
            return $this->story["option".$optionNumber]["nextAction"];
        } else {
            return $this->story["option1"]["nextAction"];
        }

    }

};

