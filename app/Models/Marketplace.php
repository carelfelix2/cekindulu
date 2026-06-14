<?php
namespace App\Models;use Illuminate\Database\Eloquent\Model;use Illuminate\Database\Eloquent\Factories\HasFactory;class Marketplace extends Model{use HasFactory; protected $fillable=['name','slug','logo','base_url','is_active']; public function prices(){return $this->hasMany(ProductPrice::class);} public function affiliateLinks(){return $this->hasMany(AffiliateLink::class);}}
