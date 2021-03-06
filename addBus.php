<?php
  include "config.php";
  $isInserted = false;
  $isunique = true;
  if(isset($_POST['addBusId']) && $_POST['addBusId'] != '' && isset($_POST['addBusCapacity']) && $_POST['addBusCapacity'] != '')
  {
    $isInserted = true;

    $sql = "SELECT COUNT(*) AS kiek
            FROM bus
            WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $_POST['addBusId']);

    $stmt->execute();
    $row = $stmt->fetch();
    if ($row['kiek'] > 0) {
      $isunique = false;
    }
    else
    {
      try
      {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO `bus` (`id`, `bus_space`)
                VALUES(? , ?)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $_POST['addBusId']);
        $stmt->bindParam(2, $_POST['addBusCapacity']);
        $stmt->execute();
      }
      catch(PDOException $e)
      {
        //echo $e->getMessage();
        $isInserted = false;
      }
    }
  }
 ?>

   <form id="addNewBus" method="post" class="form-inline">
       <div class="form-group">
         <input type="number" min=1 class="form-control" placeholder="ID" name="addBusId">
       </div>
       <div class="form-group">
         <input type="number" min=1 class="form-control" placeholder="Talpa" name="addBusCapacity">
       </div>
       <div class="form-group">
       <button href = ""type="submit" class="btn btn-default">Pridėti</button>
       <div class="form-group">
   </form>
   <br>

 <?php
 if(isset($_POST['addBusId']) && isset($_POST['addBusCapacity']))
 {
   if ($isunique)
   {

     if($isInserted)
     { ?>
         <div class="alert alert-success">
          <strong>Autobusas pridėtas.</strong>
        </div>
        <?php
      }
      else
      { ?>
      <div class="alert alert-danger">
        <strong>Nepavyko pridėti!</strong>
      </div>
      <?php
      }
  }
  else
  {?>
    <div class="alert alert-warning">
      <strong>Autobusas egzistuoja su tokiu ID</strong>
    </div>
<?php
  }
}
?>
