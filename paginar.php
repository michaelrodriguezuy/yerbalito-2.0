<?php
    class Paginar {
    
        private $conexion;
        private $limite = 10;
        private $pagina;
        private $consulta;
        private $total;
 
        public function __construct($conex, $cons) {     
            $this->conexion = $conex;
            $this->consulta = $cons;
            $respuesta = $this->conexion->query($this->consulta);
            $this->total = $respuesta->num_rows;   
        }
 
        public function getDatos($p) {     
            $this->pagina = $p;
            $inicio = ( $this->pagina - 1 ) * $this->limite ;
                
            if($inicio < 0){
                $inicio = 0;
                $this->pagina = 1;
            }
 
            if($inicio > ($this->total-$this->limite)){
                $inicio = $this->total-$this->limite;
                $this->pagina = $this->pagina-1;
            }
 
            $consultar = $this->consulta.' limit '.$inicio.','.$this->limite;
            $respuesta = $this->conexion->query($consultar);   
 
            while($row = $respuesta->fetch_assoc()) 
                $resultados[]  = $row;
                
            $result = new stdclass();
            $result->pagina = $this->pagina;
            $result->limite = $this->limite;
            $result->total = $this->total;
            $result->datos = $resultados;
 
            return $result;
        }
 
        public function crearLinks($enlaces, $pagina_actual, $total_recibos) {
            $ultimo  = ceil( $total_recibos / $this->limite);
            $comienzo = (($pagina_actual - $enlaces) > 0) ? $pagina_actual-$enlaces : 1;
            $fin  = (($pagina_actual + $enlaces ) < $ultimo) ? $pagina_actual+$enlaces : $ultimo;
            $clase = ($pagina_actual == 1) ? "disabled" : "";
            $html = '<li class="'.$clase.'"><a href="?limit='.$this->limite.'&pagina='.($pagina_actual-1).'">&laquo;</a></li>';
                
            if($comienzo > 1) {
                $html  .= '<li><a href="?limit='.$this->limite.'&pagina=1">1</a></li>';
                $html  .= '<li class="disabled"><span>...</span></li>';
            }
                
            for($i = $comienzo ; $i <= $fin; $i++) {
                $clase  = ( $pagina_actual == $i ) ? "active" : "";
                $html  .= '<li class="'.$clase.'"><a href="?limit='.$this->limite.'&pagina='.$i.'">'.$i.'</a></li>';
            }
                
            if($fin < $ultimo) {
                $html  .= '<li class="disabled"><span>...</span></li>';
                $html  .= '<li><a href="?limit='.$this->limite.'&pagina='.$ultimo.'">'.$ultimo.'</a></li>';
            }
                
            $clase  = ( $pagina_actual == $ultimo ) ? "disabled" : "enabled";
            $html  .= '<li class="'.$clase.'"><a href="?limit='.$this->limite.'&pagina='.($pagina_actual+1).'">&raquo;</a></li>';
            return $html;
        }
    }
?>