<?php


class DashboardController{

    function showDashBoard(){
        $view = new View();
        $view -> render("dashboard", []);

    }
}

?>