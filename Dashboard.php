
<?php require 'header.php';?>
    <div class="content"> <br> <br>
  <div class="cards">
    <div class="card"> 
        <span>Candidates <br> <?php echo $candidateCount; ?></span> 
        <i class="fas fa-users"></i> 
    </div>
    <div class="card"> 
        <span>Pending <br> <?php echo $pendingCount; ?></span> 
        <i class="fas fa-hourglass-half"></i> 
    </div>
    <div class="card"> 
        <span>Approved <br> <?php echo $approvedCount; ?></span> 
        <i class="fas fa-check-circle"></i> 
    </div>
    <div class="card" style="background: #e74c3c;"> 
        <span>Rejected <br> <?php echo $rejectedCount; ?></span> 
        <i class="fas fa-times-circle"></i> 
    </div>
</div>

        <div class="table-container">
              <center> <b> Last 5 Candidates<b></center>

            <table>
             <tbody>
             <tr>
            <th style="background: black; color: white; padding: 10px;">Name</th>
            <th style="background: black; color: white; padding: 10px;">Speciality</th>
            <th style="background: black; color: white; padding: 10px;">Rate</th>
            <th style="background: black; color: white; padding: 10px;">Status</th>
    

             </tr>
       <?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Escape output to prevent XSS attacks
        $name = htmlspecialchars($row['name']);
        $speciality = htmlspecialchars($row['speciality']);
        $rate = htmlspecialchars($row['rate']);
         $state = htmlspecialchars($row['state']);

        echo "<tr>
                <td>{$name}</td>
                <td>{$speciality}</td>
                <td>{$rate}</td>
                <td>{$state}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='3'>No candidates found</td></tr>";
}
?>

    </tbody>
            </table>

<?php
$conn->close();
?>
        </div>
    </div>
</body>
</html>
