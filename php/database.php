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

function getAll($pdo){
  $statement = $pdo->prepare('SELECT * FROM Boat INNER JOIN Position ON Boat.MMSI = Position.MMSI ORDER BY Boat.MMSI, Position.basedatetime;');
  $statement -> execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  if(!empty($result)){
    Response::HTTP200($result);
    exit;
  } else{
    Response::HTTP404(['error' => 'No data found']);
    exit;
  }
}

function getAllMMSI($pdo){
  $statement = $pdo->prepare('SELECT MMSI FROM Boat ORDER BY MMSI');
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  if(!empty($result)){
    Response::HTTP200($result);
    exit;
  } else{
    Response::HTTP404(['error' => 'No data found']);
    exit;
  }
}

function predType($pdo, $length, $width,  $draft){
  $pythonScript = realpath(__DIR__ . '/../assets/models/script_BC2_final.py');
  $length = escapeshellarg($length);
  $width = escapeshellarg($width);
  $draft = escapeshellarg($draft);
  $command = "python3 " . $pythonScript . " --Length " . $length . " --Width " . $width . " --Draft " . $draft;
  $output = shell_exec($command . ' 2>&1');
  $clusterValue = null;
  if (is_string($output) && trim($output) !== '') {
    if (preg_match("/Predicted VesselType:\s*\[\s*'(\d+)'\s*\]/", $output, $matches)) {
      $clusterValue = (int)$matches[1];
    } else {
      $clusterValue = $output;
    }
  } else {
    $clusterValue = 'Error: No output';
  }
  $result = $clusterValue;
  if(!empty($result)){
    Response::HTTP200($result);
    exit;
  } else{
    Response::HTTP404(['error' => 'No data found']);
    exit;
  }
}

function getBoat($pdo, $MMSI){
  $statement = $pdo->prepare('SELECT * FROM Boat WHERE MMSI = :mmsi INNER JOIN Position ON Boat.MMSI = Position.MMSI ORDER BY Boat.MMSI, Position.basedatetime;');
  $statement->bindParam(':mmsi', $MMSI);
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  if(!empty($result)){
    Response::HTTP200($result);
    exit;
  } else{
    Response::HTTP404(['error' => 'No data found'])
  }
}

function getNextPred($pdo, $latitude, $longitude, $sog, $cog, $heading, $type, $length, $width, $draft, $cargo)
  $pythonScript = realpath(__DIR__ . '/../assets/models/script_BC3_final.py')

function clusterAll($pdo){
  $statement = $pdo->prepare('SELECT * FROM Boat INNER JOIN Position ON Boat.MMSI = Position.MMSI ORDER BY Boat.MMSI, Position.basedatetime;');
  $statement -> execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  if(!empty($result)){

    $modifiedResult = [];
    foreach ($result as $row) {
      $pythonScript = realpath(__DIR__ . '/../assets/models/script_BC1_final.py');
      $latitude = escapeshellarg($row['latitude']);
Souhaite-tu gérer les deux (cluster + vessel type) dans le même script, ou c’est séparé ?      $longitude = escapeshellarg($row['longitude']);
      $sog = escapeshellarg($row['sog']);
      $cog = escapeshellarg($row['cog']);
      $heading = escapeshellarg($row['heading']);
      $command = "python3 " . $pythonScript . " --LAT " . $latitude . " --LON " . $longitude . " --SOG " . $sog . " --COG " . $cog . " --Heading " . $heading;
      $output = shell_exec($command . ' 2>&1');
      $clusterValue = null;
      if (is_string($output) && trim($output) !== '') {
        if (preg_match('/>>> Cluster prédit pour ce navire : (\d+)/', $output, $matches)) {
          $clusterValue = (int)$matches[1];
        } else {
          error_log("Python script output did not contain expected cluster line for MMSI {$row['mmsi']}:\n" . $output);
          $clusterValue = $output;
        }
      } else {
        error_log("Python script returned empty or non-string output for MMSI {$row['mmsi']}: " . var_export($output, true));
        $clusterValue = 'Error: No output';
      }
      $row['cluster'] = $clusterValue;
      $modifiedResult[] = $row;
    }
    Response::HTTP200($modifiedResult);
    exit;
  } else{
    Response::HTTP404(['error' => 'No data found']);
    exit;
  }
}



