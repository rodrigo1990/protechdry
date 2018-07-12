<?php 

	class Producto{
		public $id;
		public $marca;
		public $modelo;
		public $medida;
		public $imagen;
		public $precio;
		public $categoria;
		public $cantidad;
		public $talle;
		public $color;
		public $tiene_descuento;
		public $precio_descuento;


	public function __construct($id,$marca,$modelo,$precio,$cantidad,$imagen,$talle,$color,$tiene_descuento,$precio_descuento){
		$this->id=$id;
		$this->marca=$marca;
		$this->modelo=$modelo;
		$this->precio=$precio;
		$this->cantidad=$cantidad;
		$this->imagen=$imagen;
		$this->talle=$talle;
		$this->color=$color;
		$this->tiene_descuento=$tiene_descuento;
		$this->precio_descuento=$precio_descuento;

	}

}//class


?>