<?php

  /**
   * FallthroughContext
   *
   *   Takes n objects and attempts to find the requested field in each
   * in the order they were added (FIFE).  Thus higher priority values
   * will override lower priority values.  Useful for figuring out whether
   * or not previously entered form data or database stored object state
   * should be used to fill out the default values for a form.
   *
   * @author Daniel West <dwest at tux dot appstate dot edu>
   * @author Chris Detsch
   * @package nomination
   */
PHPWS_Core::initModClass('nomination', 'Context.php');

class FallthroughContext extends Context {
    protected $others = array();

    public function offsetExists($offset)
    {
        if(!parent::offsetExists($offset)){
            foreach($this->others as $container){
                if(isset($container[$offset]) || isset($container->$offset)){
                    return true;
                }
            }
            return false;
        }
        return true;
    }

    public function offsetGet($offset)
    {
        if(parent::offsetExists($offset)){
            return parent::offsetGet($offset);
        }

        foreach($this->others as $container){
            if(isset($container[$offset])){
                return $container[$offset];
            } elseif(isset($container->$offset)){
                return $container->$offset;
            }
        }

        return null;
    }

    public function addFallthrough($thing)
    {
        $this->others[] = $thing;
    }

    /**
     * Retrieves all the data from a nomination so that the edit form
     * can be filled back in, then calls the addFallthrough with the
     * retrieved data in an array.
     *
     * @param Nomination nomination
     */
    public function restoreNominationForm(Nomination $nomination)
    {
      $nom['nominee_banner_id'] = $nomination->getBannerId();
      $nom['nominee_first_name'] = $nomination->getFirstName();
      $nom['nominee_middle_name'] = $nomination->getMiddleName();
      $nom['nominee_last_name'] = $nomination->getLastName();
      $nom['nominee_email'] = preg_replace('/(.*)@.*appstate.edu/', '$1', $nomination->getEmail());
      $nom['nominee_asubox'] = $nomination->getAsubox();
      $nom['nominee_phone'] = $nomination->getPhone();
      $nom['nominee_position'] = $nomination->getPosition();
      $nom['nominee_major'] = $nomination->getDeptMajor();
      $nom['nominee_gpa'] = $nomination->getGpa();
      $nom['nominee_years'] = $nomination->getYearsAtASU();
      $nom['nominee_responsibility'] = $nomination->getResponsibility();
      $nom['nominee_class']  = $nomination->getClass();

      $nom['category'] = $nomination->getCategory();

      $references = ReferenceFactory::getByNominationId($nomination->getId());

      $i = 0;
      foreach ($references as $ref)
      {
        $nom['reference_id'][$i] = $ref->getId();
        $nom['reference_first_name'][$i] = $ref->getFirstName();
        $nom['reference_last_name'][$i] = $ref->getLastName();
        $nom['reference_department'][$i] = $ref->getDepartment();
        $nom['reference_phone'][$i] = $ref->getPhone();
        $nom['reference_email'][$i] = $ref->getEmail();
        $nom['reference_relationship'][$i] = $ref->getRelationship();
        $i++;
      }

      $nom['nominator_first_name'] = $nomination->getNominatorFirstName();
      $nom['nominator_middle_name'] = $nomination->getNominatorMiddleName();
      $nom['nominator_last_name'] = $nomination->getNominatorLastName();
      $nom['nominator_address'] = $nomination->getNominatorAddress();
      $nom['nominator_phone'] = $nomination->getNominatorPhone();
      $nom['nominator_email'] = preg_replace('/(.*)@.*appstate.edu/', '$1', $nomination->getNominatorEmail());
      $nom['nominator_relationship'] = $nomination->getNominatorRelation();


      $this->addFallthrough($nom);
    }


}
