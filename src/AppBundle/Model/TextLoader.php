<?php

namespace AppBundle\Model;

class TextLoader{

    private $text;
    private $pdf;
    private $tmpPath;
    private $permanentPath;

    /**
     * TextLoader constructor.
     * @param $filePost
     */
    function __construct($filePost){

        $this->tmpPath = "C:\\xampp\\htdocs\\quizzer\\uploads\\";
        $this->permanentPath = "C:\\xampp\\htdocs\\quizzer\\uploads\\";

        if (!empty($filePost)) {

            $this->checkValidParameter($filePost);

            $parser = new \Smalot\PdfParser\Parser();

            $this->pdf = $parser->parseFile($this->tmpPath.$filePost['name']);
            $this->text = $this->pdf->getText();
        }
    }

    public function checkValidParameter($file)
    {
        //archivo existente
        if( $file["size"] == 0 ) {
            throw new \Exception("Debe seleccionar un texto");
        }

        //tamaño máximo no excedido
        if( $file['size'] >= 1048576 /*MB*/ * 10 ) {
            throw new \Exception("El archivo excede el máximo permitido");
        }

        //error al cargar el archivo
        if ($file["error"] !== UPLOAD_ERR_OK) {
            throw new \Exception("Ocurrio un error cargando el archivo.");
        }

        //reemplazo el nombre del  archivo por uno no conflictivo
        $name = preg_replace("/[^A-Z0-9._-]/i", "_", $file["name"]);

        //error de extension (solo se admiten pdfs)
        $parts = pathinfo($name);
        if($parts["extension"]!='pdf'){
            throw new \Exception("El archivo debe ser PDF.");
        }

        //no sobreescribo archivos
        $i = 0;
        while (file_exists($this->tmpPath . $name)) {
            $i++;
            $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
        }
        //guardo archivo temporal como permanente en un dir de la app
        $success = move_uploaded_file($file["tmp_name"],$this->permanentPath . $name);
        if (!$success) {
            throw new \Exception("Ocurrio un error guardando el archivo.");
        }
    }

    public function getText(){
        return $this->text;
    }

    public function getPdf(){
        return $this->pdf;
    }


}