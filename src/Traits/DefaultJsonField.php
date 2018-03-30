<?php

namespace Goodwong\DefaultJsonField\Traits;

trait DefaultJsonField
{
    /**
     * hook into creating / saving
     */
    public static function boot()
    {
        static::creating(function ($model) {
            $model->defaults();
        });

        static::updating(function ($model) {
            $model->defaults();
        });
        
        parent::boot();
    }

    /**
     * merge defaults to field value
     *
     * @return  self
     */
    public function defaults()
    {
        $properties = array_keys(get_object_vars($this));
        foreach ($properties as $property) {
            if ( ! starts_with($property, 'default_')) {
                continue;
            }
            $field = str_replace('default_', '', $property);
            $this->mergeDefaultFields($field);
        }
        return $this;
    }

    /**
     * merge defaults to field value
     *
     * @param  string  $field
     * @return void
     */
    private function mergeDefaultFields($field)
    {
        $default = 'default_' . $field;
        // merge data
        $data = (array)$this->$field;
        $data =  $data + $this->$default;
        $data = (object)$data;
        // detect if need to update database
        $_old = json_encode($this->$field);
        $_new = json_encode($data);
        if ($_old != $_new) {
            $this->$field = $data;
        }
    }

    /**
     * __toArray
     * 
     * @return array
     */
    public function toArray()
    {
        $this->defaults();
        return parent::toArray();
    }
}
