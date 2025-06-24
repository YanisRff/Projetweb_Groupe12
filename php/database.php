<?php
require_once('constants.php');
require_once('Routeur/response.php');

/**
 * Create the connection to the database.
 * @return PDO|false
 */
function dbConnect()
{
    try
    {
      $db = new PDO('pgsql:host='.DB_SERVER.';port='.DB_PORT.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $exception)
    {
      error_log('Connection error: '.$exception->getMessage());
      return false;
    }
    return $db;
}

function getTable($pdo){
    error_log("getTable called");
    $statement = $pdo->prepare('SELECT * FROM Boat');
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    error_log("Result count: " . count($result));

    if (!empty($result)) {
        Response::HTTP200($result);
        error_log("Response sent with data");
        exit;
    } else {
        Response::HTTP404(['error' => 'No data found']);
        error_log("Response sent: no data");
        exit;
    }
}

function saveData($pdo, $mmsi, $horodatage, $latitude, $longitude, $sog, $cog, $heading, $name, $length, $width, $draft, $status){
    $boatStatement = $pdo->prepare('
        INSERT INTO Boat (mmsi, name, length, width, draft)
        VALUES (:mmsi, :name, :length, :width, :draft)
        ON CONFLICT (mmsi) DO UPDATE SET
            name = EXCLUDED.name,
            length = EXCLUDED.length,
            width = EXCLUDED.width,
            draft = EXCLUDED.draft
    ');

    $boatStatement->bindParam(':mmsi', $mmsi);
    $boatStatement->bindParam(':name', $name);
    $boatStatement->bindParam(':length', $length);
    $boatStatement->bindParam(':width', $width);
    $boatStatement->bindParam(':draft', $draft);

    try {
        $boatStatement->execute();
        $positionStatement = $pdo->prepare('
            INSERT INTO Position (mmsi, basedatetime, latitude, longitude, sog, cog, heading, status, prediction)
            VALUES (:mmsi_pos, :basedatetime, :latitude, :longitude, :sog, :cog, :heading, :status, false)
        ');
        $positionStatement->bindParam(':mmsi_pos', $mmsi);
        $positionStatement->bindParam(':basedatetime', $horodatage);
        $positionStatement->bindParam(':latitude', $latitude);
        $positionStatement->bindParam(':longitude', $longitude);
        $positionStatement->bindParam(':sog', $sog);
        $positionStatement->bindParam(':cog', $cog);
        $positionStatement->bindParam(':heading', $heading);
        $positionStatement->bindParam(':status', $status);

        $positionStatement->execute();

        if ($positionStatement->rowCount() == 1) {
            return Response::HTTP200(['success' => true]);
        } else {
            error_log("Error: Position insert failed (rowCount was not 1) for MMSI: " . $mmsi);
            return Response::HTTP404(['error' => 'Error while saving position data']);
        }

    } catch (PDOException $e) {
        error_log("PDOException in saveData for MMSI: " . $mmsi . " - " . $e->getMessage());
        if ($e->getCode() == '23505') {
             return Response::HTTP409(['error' => 'Conflict: Boat with this MMSI already exists and could not be updated or position linked.']);
        }
        return Response::HTTP500(['error' => 'Database error: ' . $e->getMessage()]);
    }
}

function getUser($db, $id){
    $query = $db->prepare('SELECT * FROM Users WHERE id_user = :id_user');
    $query->execute(array(':id_user' => $id));
    $result = $query->fetch(PDO::FETCH_ASSOC);

    return $result;
}
