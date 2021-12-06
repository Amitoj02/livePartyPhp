<?php

    require __DIR__.'/firebase_sdk/vendor/autoload.php';
        
    use Kreait\Firebase\Factory;
    $factory = (new Factory)
            ->withServiceAccount('/path/to/firebase_admin_credentials.json') //secret admin sdk credentials
            ->withDatabaseUri('https://PROJECT_ID-default-rtdb.firebaseio.com'); //rtdb url


    $database = $factory->createDatabase();

    $reference = $database->getReference('messages/');
    $messages = $reference->getValue();

    if ( count($messages) > 20) {

        //number of messages to be deleted
        $delNum = count($messages) - 20;
        $old_messages = array_slice($messages, 0, $delNum);

        foreach ($old_messages as $old_message) {
            //echo $old_message['message'];
            $database->getReference('messages/'. $old_message['id'])->remove();
        }
        echo 'messages removed: '. $delNum;

    } else {
        echo 'looks fine';
    }


    //var_dump ( $value);

    function give_output($status, $message) {
        $outputObj = (object)array();

        $outputObj->status = $status;
        $outputObj->message = $message;
        
        exit(json_encode($outputObj));
    }


?>
