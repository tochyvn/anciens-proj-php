<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    include'ConnectBDD.php';
    $sql = "SELECT * FROM `article`";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo'<div class="post-preview">
                    <a href="post.html">
                        <h2 class="post-title">'
                           .$row["titreArticleFR"].
                        '</h2>
                        <h3 class="post-subtitle">'
                            .$row["txtArticleFR"].
                        '</h3>
                    </a>';  
                    $sqlimg= "SELECT * FROM `photolieu` WHERE `idLieu`=".$row["idLieu"];
                    $resultimg = $conn->query($sqlimg);
                    if ($resultimg->num_rows > 0) {
                        while($rowimg = $resultimg->fetch_assoc()) {
                            echo'<blockquote>The dreams of yesterday are the hopes of today and the reality of tomorrow. Science has not yet mastered prophecy. We predict too much for the next year and yet far too little for the next ten.</blockquote>
                            <img class="imghead img-responsive" src="'.$rowimg["lienPhoto"].'" alt="">';
                        }
                    }
                echo'</div>
                <hr>
                <ul class="pager">
                    <li class="next">
                       <blockquote>The dreams of yesterday are the hopes of today and the reality of tomorrow. Science has not yet mastered prophecy. </blockquote>
                    </li>
                </ul><hr>';  
        }
    } else {
        echo    '<div class="post-preview">
                    <a href="post.html">
                        <h2 class="post-title">
                           YOOLOtitre
                        </h2>
                        <h3 class="post-subtitle">
                             YOOLOcontent
                        </h3>
                    </a>
                    <p class="post-meta">Posted by <a href="#">Start Bootstrap</a> on September 24, 2014</p>
                </div>';
    }
    $conn->close();
?>