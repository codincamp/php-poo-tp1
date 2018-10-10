<?php

class Personnage
{
    private $_degats;
    private $_id;
    private $_nom;
    private $_experience;
    private $_level;
    
    const CEST_MOI = 1; // Constante renvoyée par la méthode `frapper` si on se frappe soi-même.
    const PERSONNAGE_TUE = 2; // Constante renvoyée par la méthode `frapper` si on a tué le personnage en le frappant.
    const PERSONNAGE_FRAPPE = 3; // Constante renvoyée par la méthode `frapper` si on a bien frappé le personnage.

    const DAMAGE_MIN = 5;
    const DAMAGE_MAX = 25;
    const LEVEL_THRESHOLD = 100;
    
    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }
    
    public function frapper(Personnage $perso)
    {
        if ($perso->id() == $this->_id) {
            return self::CEST_MOI;
        }

        // Increase experience
        $this->_experience++;

        // Check if we need to increase a level
        if ($this->_experience >= self::LEVEL_THRESHOLD) {
            // 1. Reset experience
            $this->_experience = 1;
            // 2. Increase level
            $this->_level++;
        }
    
        // On indique au personnage qu'il doit recevoir des dégâts.
        // Puis on retourne la valeur renvoyée par la méthode : self::PERSONNAGE_TUE ou self::PERSONNAGE_FRAPPE
        return $perso->recevoirDegats();
    }
    
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = 'set'.ucfirst($key);
        
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function recevoirDegats()
    {
        $this->_degats += rand(self::DAMAGE_MIN, self::DAMAGE_MAX);
    
        // Si on a 100 de dégâts ou plus, on dit que le personnage a été tué.
        if ($this->_degats >= 100) {
            return self::PERSONNAGE_TUE;
        }
    
        // Sinon, on se contente de dire que le personnage a bien été frappé.
        return self::PERSONNAGE_FRAPPE;
    }
    
    // GETTERS //
    public function degats()
    {
        return $this->_degats;
    }
    
    public function id()
    {
        return $this->_id;
    }
    
    public function nom()
    {
        return $this->_nom;
    }

    public function experience()
    {
        return $this->_experience;
    }

    public function level()
    {
        return $this->_level;
    }
    
    public function setDegats($degats)
    {
        $degats = (int) $degats;
    
        if ($degats >= 0 && $degats <= 100) {
            $this->_degats = $degats;
        }
    }
    
    public function setId($id)
    {
        $id = (int) $id;
    
        if ($id > 0) {
            $this->_id = $id;
        }
    }
    
    public function setNom($nom)
    {
        if (is_string($nom)) {
            $this->_nom = $nom;
        }
    }

    public function setExperience($experience)
    {
        $this->_experience = $experience;
    }

    public function setLevel($level)
    {
        $this->_level = $level;
    }

    public function nomValide()
    {
        return !empty($this->_nom);
    }
}
