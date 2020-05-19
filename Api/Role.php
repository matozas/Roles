<?php namespace App;


use Trebol\Entrust\EntrustRole;

class Role extends EntrustRole
{
   protected $fillable = [
      'name', 'display_name','permissions'
  ];
   public function permissions(){
       return $this->hasMany(PermissionRole::class, 'role_id');
    }

    public function roleuser(){
       return $this->hasMany(RoleUser::class, 'role_id');
    }
}
