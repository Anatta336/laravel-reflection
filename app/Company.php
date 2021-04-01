<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Eloquent Model to represent companies.
 *
 * @package Company
 */
class Company extends Model
{
    /**
     * @var array Fields that cannot be mass assigned.
     */
    protected $guarded = ['id'];

    /**
     * Defines the has-many relationship with employees.
     *
     * @return Relation
     */
    public function employees()
    {
        return $this->hasMany(Employee::class, 'company_id', 'id');
    }

    /**
     * @param UploadedFile $file Image file containing logo. Should have
     *                           already undergone any validation necessary.
     *
     * @return string Path of where the file is stored in the public disk.
     */
    public function storeLogo($file)
    {
        // delete existing logo file, unless it's a sample logo
        if ($this->logo && !Str::contains($this->logo, 'logos/samples/')) {
            Storage::disk('public')->delete($this->logo);
        }

        // store file and record path
        return $this->logo = Storage::disk('public')->putFile('logos', $file, 'public');
    }
}
