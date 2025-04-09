
<?php require 'header.php';?>
   
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
              <center> <b>All Candidates<b></center>

            <table>
             <tbody>
             <tr>
             <th style="background: black; color: white; padding: 10px;">
        <a href="?orderBy=name&orderDir=<?php echo ($orderBy == 'name' && $orderDir == 'ASC') ? 'desc' : 'asc'; ?>" style="color: white; text-decoration: none;">
            Name <?php echo ($orderBy == 'name') ? ($orderDir == 'ASC' ? '🔼' : '🔽') : ''; ?>
        </a>
    </th>
    <th style="background: black; color: white; padding: 10px;">
        <a href="?orderBy=speciality&orderDir=<?php echo ($orderBy == 'speciality' && $orderDir == 'ASC') ? 'desc' : 'asc'; ?>" style="color: white; text-decoration: none;">
            Speciality <?php echo ($orderBy == 'speciality') ? ($orderDir == 'ASC' ? '🔼' : '🔽') : ''; ?>
        </a>
    </th>
    <th style="background: black; color: white; padding: 10px;">
        <a href="?orderBy=interviewer&orderDir=<?php echo ($orderBy == 'interviewer' && $orderDir == 'ASC') ? 'desc' : 'asc'; ?>" style="color: white; text-decoration: none;">
            Interviewer <?php echo ($orderBy == 'interviewer') ? ($orderDir == 'ASC' ? '🔼' : '🔽') : ''; ?>
        </a>
    </th>
<th style="background: black; color: white; padding: 10px;">
        <a href="?orderBy=interviewer&orderDir=<?php echo ($orderBy == 'interview_date' && $orderDir == 'ASC') ? 'desc' : 'asc'; ?>" style="color: white; text-decoration: none;">
            Interview Date <?php echo ($orderBy == 'interview_date') ? ($orderDir == 'ASC' ? '🔼' : '🔽') : ''; ?>
        </a>
    </th>

    <th style="background: black; color: white; padding: 10px;">CV</th>
    <th style="background: black; color: white; padding: 10px;">
        <a href="?orderBy=rate&orderDir=<?php echo ($orderBy == 'rate' && $orderDir == 'ASC') ? 'desc' : 'asc'; ?>" style="color: white; text-decoration: none;">
            Rate <?php echo ($orderBy == 'rate') ? ($orderDir == 'ASC' ? '🔼' : '🔽') : ''; ?>
        </a>
    </th>
    <th style="background: black; color: white; padding: 10px;">
        <a href="?orderBy=state&orderDir=<?php echo ($orderBy == 'state' && $orderDir == 'ASC') ? 'desc' : 'asc'; ?>" style="color: white; text-decoration: none;">
            Status <?php echo ($orderBy == 'state') ? ($orderDir == 'ASC' ? '🔼' : '🔽') : ''; ?>
        </a>
    </th>
    <th style="background: black; color: white; padding: 10px;">Action</th>
    

             </tr>
  <?php
// تأكد من وجود اتصال بقاعدة البيانات
if (!$conn) {
    die("خطأ في الاتصال بقاعدة البيانات: " . mysqli_connect_error());
}

// استعلام جلب جميع المرشحين
$sqlall = "SELECT * FROM Candidates";
$resultall = $conn->query($sqlall);

// تحديد المعايير الافتراضية للفرز
$orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : 'name';  
$orderDir = (isset($_GET['orderDir']) && $_GET['orderDir'] === 'desc') ? 'DESC' : 'ASC'; 

// الحماية من إدخال غير صحيح في orderBy
$allowedColumns = ['name', 'speciality', 'interviewer', 'cv_path', 'rate', 'state']; 
if (!in_array($orderBy, $allowedColumns)) {
    $orderBy = 'name'; // إعادة تعيين إلى القيمة الافتراضية
}

// استعلام جلب البيانات مع الفرز
$queryall = "SELECT * FROM Candidates ORDER BY $orderBy $orderDir";
$resultallall = $conn->query($queryall);

// 🔹 عرض الاستعلام لمعرفة المشكلة (مؤقتًا للتحقق من الأخطاء)
if (!$resultallall) {
    die("❌ خطأ في الاستعلام: " . $conn->error); 
}

// 🔹 التحقق من وجود بيانات قبل الطباعة
if ($resultallall->num_rows > 0) {
    while ($row = $resultallall->fetch_assoc()) {
        // تأمين البيانات لمنع هجمات XSS
        $id = htmlspecialchars($row['id']); 
        $name = htmlspecialchars($row['name']);
        $speciality = htmlspecialchars($row['speciality']); 
        $interviewer = htmlspecialchars($row['interviewer']);
        $interview_date = htmlspecialchars($row['interview_date']);
        
        $cv = htmlspecialchars($row['cv_path']);
        $rate = htmlspecialchars($row['rate']);
        $state = htmlspecialchars($row['state']);

        echo "<tr>
                <td>{$name}</td>
                <td>{$speciality}</td>
                <td>{$interviewer}</td>
                <td>{$interview_date}</td>
                <td><a href='{$cv}' target='_blank' class='view-button' style='text-decoration: none; color: blue; font-weight: bold;'>View CV</a></td>
                <td>{$rate}</td>
                <td>{$state}</td>
                <td>
                    <a href='view_candidate.php?id={$id}' class='view-button' style='text-decoration: none; color: blue; font-weight: bold;'>👁️ View</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='7' style='text-align:center; color:red;'>🚨 لا يوجد مرشحون متاحون</td></tr>";
}
?>



        </div>
    </div>
</body>
</html>
