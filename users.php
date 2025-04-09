
<?php require 'header.php';?>
<style>
       
    .form-container {
        width: 400px;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .form-group {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .form-group input, .form-group select {
        width: 48%; /* يجعل الحقول متجاورة */
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .full-width {
        width: 100%;
    }
    button {
        width: 100%;
        background: #007bff;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
    button:hover {
        background: #0056b3;
    }
    
    </style>

    <div class="content"> 
  <div class="cards">
</div>

      
<div class="form-container">
    <form method="post">
        <div class="form-group">
            <input type="text" id="name" name="name" placeholder="Name" required>
            <input type="text" id="username" name="username" placeholder="Username" required>
        </div>
        <div class="form-group">
            <input type="password" id="password" name="password" placeholder="Password" required>
            <select id="role" name="role" required>
                <option value="">Select Role</option>
                <option value="Admin">Admin</option>
                <option value="Recruiter">Recruiter</option>
            </select>
        </div>
        <button type="submit" name="addU">Add User</button>
    </form>
</div>
<center> <b>Users<b></center>

     <table border="1">
    <thead>
        <tr>
            <th>Name</th>
            <th>Role</th>
             <th>Added By</th>
            <th>Action</th>
        </tr>
    </thead> 
    <tbody>
    <?php
    if ($resultusers->num_rows > 0) {
        while ($uRow = $resultusers->fetch_assoc()) {
            $user_id = htmlspecialchars($uRow['id']);
            $username = htmlspecialchars($uRow['username']);
            $name = htmlspecialchars($uRow['name']);
            $role = htmlspecialchars($uRow['role']);
            $added_by = htmlspecialchars($uRow['added_by']);
    ?>
            <tr>
                <td><?php echo $name; ?></td>
                <td><?php echo $role; ?></td>
                <td><?php echo $added_by; ?></td>
                <td>
                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <?php if ($username !== "abosaed2015") { ?>
                            <button type="submit" name="deleteU" style="background: none; border: none; cursor: pointer; color: red; font-size: 18px;">❌</button>
                        <?php } else { ?>
                            <span style="color: gray;">Cannot delete</span>
                        <?php } ?>
                    </form>
                </td>
            </tr>
    <?php
        }
    } else {
        echo "<tr><td colspan='4'>No users found</td></tr>";
    }
    ?>
</tbody>

</table>

        </div>
    </div>
</body>
</html>
