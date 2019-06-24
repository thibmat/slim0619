<?php
namespace App\Utilities;

class FormValidator
{

    /**
     * Verification de la clef dans la superglobale POST et renvoi
     * de l'éventuel message d'erreur à afficher dans l'HTML (texte)
     * @param string $key La clef située dans $_POST
     * @param int $max Le nombre de caractères maximum autorisé
     * @return string L'éventuel message d'erreur
     */
    public static function checkPostText(string $key, int $max): string
    {
        // On teste l'existence et la non-nullité
        if (!array_key_exists($key, $_POST) || empty($_POST[$key])) {
            $message = "Merci de saisir une valeur";
            // On teste la valeur max
        } elseif (strlen($_POST[$key]) > $max) {
            $message = "La valeur saisie est trop longue (max $max caractères)";
        }
        // On retourne l'éventuel message ou une chaîne de caractères vide
        return $message ?? '';
    }
    /**
     * Verification de la clef dans la superglobale POST et renvoi
     * de l'éventuel message d'erreur à afficher dans l'HTML (nombres)
     * @param string $key La clef dans $_POST
     * @param float $min Valeur mini autorisée
     * @param float $max Valueur maxi autorisée
     * @param bool $isFloat Est-ce un nombre à virgule ? (intval, floatval)
     * @return string L'éventuel message d'erreur
     */
    public static function checkPostNumber(string $key, float $min, float $max, bool $isFloat = true): string
    {
        //// Existence
        if (!array_key_exists($key, $_POST) || $_POST[$key] === '' || is_null($_POST[$key])) {
            $message = "Veuillez saisir une valeur";
        } elseif (!is_numeric($_POST[$key])) {
            $message = "La valeur saisir doit être un nombre";
        } else {
            if ($isFloat) {
                $_POST[$key] = floatval($_POST[$key]);
            } else {
                $_POST[$key] = intval($_POST[$key]);
            }
            //// Valeur mini (0)
            if ($_POST[$key] < $min) {
                $message = "La valeur doit être supérieur à $min";
            }
            //// Valeur maxi (10 millions)
            if ($_POST[$key] > $max) {
                $message = "La valeur doit être inférieur à $max";
            }
        }
        return $message ?? "";
    }
    /**
     * Vérification d'un input de type "date", retour du message d'erreur
     * @param string $key La clef dans $_POST
     * @return string Eventuel message d'erreur
     */
    public static function checkPostDate(string $key): string
    {
        if (!array_key_exists($key, $_POST) || $_POST[$key] === '') {
            $message = "Merci de saisir la date";
        } else {
            // On décompose la date de création en 3 parties
            $tabCreatedAt = explode('-', $_POST[$key]);
            // On vérifie qu'on a bien les 3 composantes de la date
            if(
                sizeof($tabCreatedAt) !== 3 ||
                !checkdate($tabCreatedAt[1], $tabCreatedAt[2], $tabCreatedAt[0])
            ) {
                $message = "Il faut saisir une date valide!";
            }
        }
        return $message ?? "";
    }
    public static function sanitizeRadio(string $key): void {
        if (!array_key_exists($key, $_POST)) {
            $_POST[$key] = false;
        } else {
            $_POST[$key] = true;
        }
    }
    public static function checkPostEmail(string $key, int $max):string
    {
        // On teste l'existence et la non-nullité
        if (!array_key_exists($key, $_POST) || empty($_POST[$key])) {
            $message = "Merci de saisir une valeur";
            // On teste la valeur max
        } elseif (strlen($_POST[$key]) > $max) {
            $message = "La valeur saisie est trop longue (max $max caractères)";
        } elseif (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $_POST[$key])){
            $message = "L'email ne semble pas correct";
        }
        // On retourne l'éventuel message ou une chaîne de caractères vide
        return $message ?? '';
    }

    /**
     * Cette fonction vérifie que l'upload d'un fichier s'est bien passé.
     * @param string $key : Nom du champ dans le formulaire
     * @param int $maxSize : taille max du fichier (en Mo)
     * @param string $dir : Repertoire de destination
     * @param array $acceptedFormats : Tableau avec les formats acceptés
     * @return string
     */
    public static function checkPostFile(string $key, int $maxSize, string $dir, array $acceptedFormats, string $timestamp):string
    {
        $message='';
        $chemin_image = '';
        if(!array_key_exists($key, $_FILES) || empty($_FILES[$key]) && $_FILES[$key]["error"] != 0) {
            $message = "L'upload du fichier a échoué : " . $_FILES[$key]["error"];
        }else{

            $filename = $_FILES[$key]["name"];
            $filetype = $_FILES[$key]["type"];
            $filesize = $_FILES[$key]["size"];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $nomDuFichier = pathinfo($filename, PATHINFO_FILENAME);

            if (!array_key_exists($ext, $acceptedFormats)) {
                $message = "Erreur : L'extension de votre fichier n'est pas valide.";
            }else{

                $maxsize = $maxSize * 1024 * 1024;
                if ($filesize > $maxsize){
                    $message = "Erreur : Votre fichier est trop lourd";

                }else{
                    if(in_array($filetype, $acceptedFormats)){

                        if(file_exists(dirname(__DIR__,2)."/public/img/". $dir . "/" . $_FILES[$key]["name"])) {
                            $message = $_FILES[$key]["name"] . " existe déjà.";

                        }else {
                            move_uploaded_file($_FILES[$key]["tmp_name"], dirname(__DIR__,2)."/public/img/". $dir . "/" . $nomDuFichier.$timestamp.".".$ext);
                        }
                    }
                }
            }
        }
        return $message;
    }
    public function validate(array $datas)
    {
        $errors = [];
        foreach ($datas as $data) {
            if ($data[1] == 'text') {
                $errors[$data[0]] = self::checkPostText($data[0], $data[2]);
            }elseif ($data[1] == 'date') {
                $errors[$data[0]] = self::checkPostDate($data[0]);
            }
            elseif ($data[1] == 'file'){
                $errors[$data[0]] = self::checkPostFile($data[0],$data[2],$data[3],$data[4],$data[5]);
            }
        }
        return $errors;
    }

    public function generateInputText(string $key, string $type, string $label, array $errors, ?string $defaultValue=''): string {
        $isError = array_key_exists($key, $errors) && !empty($errors[$key])? 'is-invalid' : '';
        $value = $defaultValue;
        $error = $errors[$key] ?? "";
        return <<<EOT
<div class="form-group">
<label for="$key">$label</label>
<input  type="$type"
        class="form-control $isError"
        id="$key" name="$key" value="$value">
<div class="invalid-feedback">$error</div>
</div>
EOT;
    }
    public function generateInputTextArea(string $key, string $label, int $lignes, array $errors, ?string $defaultValue=''): string {
        $isError = array_key_exists($key, $errors) && !empty($errors[$key])? 'is-invalid' : '';
        $value = $defaultValue;
        $error = $errors[$key] ?? "";
        return <<<EOT
<div class="form-group">
<label for="$key">$label</label>
<textarea class="form-control" id="$key" name="$key" rows="$lignes">$value</textarea>
<div class="invalid-feedback">$error</div>
</div>
EOT;
    }
}



