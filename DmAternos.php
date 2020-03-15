<?php
    /* 
        Api creada por DickyMontiel
        Github: https://github.com/DickyMontiel
        Fecha de creación: 14-03-2020
        Email: frederickm.kinal@gmail.com
        Teléfono: +502 56785549

        --------------------------- ¿Cómo usarlo? ------------------------------
        1) Escoge una ip de algún servidor de aternos.
        2) Instancia la clase DmAternos en tu archivo a usarlo colocando este codigo:

            $DmAternos = new DmAternos;
        
        3) Crea una variable "$ip" con la ip del servidor 
        4) Usaremos la clase DmAternos, llamando a la funcion verificar, enviandole el parametro que es la ip:

            $respuesta = $DmAternos->verificar($ip);
        
            Si respuesta es igual a 0, es porque el servidor esta Offline.
            Si es 1, está Online.
            Si es 2, no existe.
            Si es 3, la ip esta mal escrita.

        !!!!!!!!!!!!!!!!!!!!!!IMPORTANTE¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡
        Si el codigo de DmAternos no se encuentra en el archivo donde se mostrará.
        Antes de instanciar la clase, incluye el archivo con:

            include("[Ruta]/DmAternos.php");

    */

    class DmAternos{
        public $ip;
        public $respuesta;
        public $estado;

        function verificar($ip){
            if(strpos($ip, ".aternos.me")){
                $ip = $ip;
            }else{
                $ip = $ip.".aternos.me"; 
            }

            if(strpos($ip, "https://")){
                $this->ip = $ip; 
            }else{
                $this->ip = "https://".$ip; 
            }

            $ch =           curl_init($this->ip);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $respuesta =    curl_exec($ch);
                            curl_close($ch);

            if(strpos($respuesta, "Offline")){
                $this->estado = 0;
            }elseif(strpos($respuesta, "Online")) {
                $this->estado = 1;
            }else{
                $this->estado = 2;
            }

            return $this->estado;
        }
    }
?>