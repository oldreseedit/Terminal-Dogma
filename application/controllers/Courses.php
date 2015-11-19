<?php
class Courses extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper('url');
        }
        
        public function index()
        {
            $this->load->view('courses/courses');
        }
        
        public function get()
        {
            $courseID = $this->input->post('courseID');
            if($courseID == false)
            {
                echo json_encode(array("error" => true, "description" => "Specificare un corso.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("courseID")));
                return;
            }

            $description = "";
            $icon = $courseID;
            $syllabus = array();
            
            switch($courseID)
            {
                case "3DStudioMax":
                        $description = "Il corso di 3D Studio Max introduce concetti chiave della grafica 3D quali modellazione, texturing, illuminazione, rendering e fondamenti di animazione all’interno del pacchetto di modellazione tridimensionale 3DS Max.
Gli studenti apprenderanno inoltre l’uso base del motore di rendering V-Ray per effettuare la resa finale dei loro lavori
La fase di simulazione prevede la creazione di materiale grafico per lo sviluppo di un videogioco in collaborazione con il team di design, che si occuperà dalla progettazione, e con il team di sviluppo, che si occuperà dell’implementazione concreta del gioco.
Gli studenti dovranno realizzare uno studio di fattibilità a partire da una bozza di design, fornire gli asset grafici sia per il prototipo che per il gioco vero e proprio, rimanendo in costante contatto con il team di design e il team grafico.";
                        array_push($syllabus, "Concetti base della grafica 3d: vertici, poligoni, mesh, etc.");
                        array_push($syllabus, "Interfaccia di 3D Studio MaX");
                        array_push($syllabus, "Forme geometriche primitive");
                        array_push($syllabus, "Modificatori e oggetti composti");
                        array_push($syllabus, "Modellazione poligonale");
                        array_push($syllabus, "Illuminazione: luci, ombre, illuminazione globale");
                        array_push($syllabus, "Texturing: editor di materiali, UVW map, etc.");
                        array_push($syllabus, "Fondamenti di animazione: traslazioni, rotazioni, etc.");
                        array_push($syllabus, "Rendering in V-Ray");
                        break;
                        
                case "gameDesign":
                        $description = "Il corso di Game Design mira a insegnare i fondamenti della progettazione videoludica e ad analizzare l’intero processo di sviluppo di un videogioco con particolare attenzione alle fasi di ideazione, design, testing e marketing.
Tramite l’analisi di famosi successi e insuccessi lo studente imparerà a vedere ogni videogioco sotto una luce completamente diversa, individuando subito le meccaniche principali e il loro ruolo all’interno del gameplay.

Durante la fase di simulazione gli studenti saranno chiamati a progettare un gioco seguendo le indicazioni del produttore e coordinandosi con il team di sviluppo, che si occuperà dell’implementazione, e con il team grafico, responsabile della creazione di asset grafici.
Il Design Team dovrà quindi ideare e progettare il gioco, stendendo e aggiornando il game design document, analizzando prototipi e versioni di sviluppo fornite dagli altri team, organizzando testing del gioco e campagne di marketing.";
                        array_push($syllabus, "Le sfide del design: obiettività, visione di insieme, trappole emotive, idee, paralisi da analisi.");
                        array_push($syllabus, "Generi di gioco e le loro evoluzioni.");
                        array_push($syllabus, "Progettazione videoludica: rapporto tra meccanica, storia, estetica e tecnologia");
                        array_push($syllabus, "Scrivere un Game Design Document");
                        array_push($syllabus, "Bilanciamento");
                        array_push($syllabus, "Analisi di design: Quake 3 vs Unreal Tournament, Lol vs DotA");
                        array_push($syllabus, "Analisi della situazione attuale: come può uno sviluppatore indipendente pubblicare un gioco?");
                        array_push($syllabus, "Testing");
                        array_push($syllabus, "Marketing");
                        break;
                        
                case "gameMaker":
                        $description = "Il corso di Game Maker mira a dare una conoscenza completa dell’ambiente di sviluppo videoludico Game Maker Studio: partendo dalle basi, a fine corso gli studenti saranno in grado di creare un videogioco di qualità professionale da zero.

Durante la fase di simulazione gli studenti dovranno realizzare uno studio di fattibilità a partire dalla bozza di design fornita dal Design Team, creare un prototipo per l’analisi preliminare dell’idea e sviluppare poi in concreto il gioco, rimanendo in costante contatto con il team di design e il team grafico.";
                        array_push($syllabus, "La filosofia di Game Maker");
                        array_push($syllabus, "I componenti base di un gioco Game Maker");
                        array_push($syllabus, "Strumenti avanzati");
                        array_push($syllabus, "Esportazione del gioco");
                        array_push($syllabus, "Implementare capolavori del passato; Space Invaders, Asteroids, Breakout, etc.");
                        break;
            }
            
            $course = array('icon' => $icon, 'description' => $description, 'syllabus' => $syllabus);
            echo json_encode($course);
            return;
        }
}
?>