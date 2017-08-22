<?php
    
    function redirect_to($new_location)
    {
        header("Location: " . $new_location);
        exit;
    }

    function mysql_prep($string)
    {
        global $connection;

        $escaped_string = mysqli_real_escape_string($connection, $string);
        return $escaped_string;
    }

    function confirm_query($result_set)
    {
        if(!$result_set)
        {
            die("Database query failed");
        }
    }

    function check_win($value)
    {
        if($value)
        {
            $query = "UPDATE {$_SESSION['group_id']} SET score = score + 1 WHERE player_name = '{$value}'";
            $result = mysql_query($query);
        }
    }

    function attempt_login($username, $password)
    {
        $admin = find_admin_by_username($username);
        if($admin)
        {
            if(password_verify($password, $admin['hashed_password']))
            {
                return $admin;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    function attempt_group_login($group_name, $password)
    {
        $group = find_group_by_groupname($group_name);
        if($group)
        {
            if(password_verify($password, $admin['hashed_password']))
            {
                return $admin;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    function form_errors($errors = array())
    {
        $output = "";
        if(!empty($errors))
        {
            $output .= "<div class=\"error\">";
            $output .=  "Please fix the following errors:";
            $output .= "<ul>";
            foreach($errors as $key => $error)
            {
                $output .= "<li>";
                $output .= htmlentities($error);
                $output .= "</li>";
            }
            $output .= "</ul>";
            $output .= "</div>";
        }
        return $output;
    }

    function find_all_players()
    {   
        global $connection;

        $query = "SELECT * ";
        $query .= "FROM divisionof ";
        $query .= "ORDER BY player_name ASC";

        $player_set = mysqli_query($connection, $query);
        confirm_query($player_set);
        return $player_set;
    }

    function find_all_admins()
    {   
        global $connection;

        $query = "SELECT * ";
        $query .= "FROM group ";
        $query .= "ORDER BY player_name ASC";

        $admin_set = mysqli_query($connection, $query);
        confirm_query($admin_set);
        return $admin_set;
    }

    function logged_in()
    {
        return isset($_SESSION['id']);
    }

    function confirm_logged_in()
    {
        if(!logged_in())
        {
            redirect_to("login.php");
        }
    }

    function find_admins_by_id($admin_id)
    {
        global $connection;

        $safe_admin_id = mysqli_real_escape_string($connection, $admin_id);

        $query = "SELECT * ";
        $query .= "FROM login_list ";
        $query .= "WHERE id = {$safe_admin_id} ";
        $query .= "LIMIT 1";
        $admin_set = mysqli_query($connection, $query);
        confirm_query($admin_set);
        if($admin = mysqli_fetch_assoc($admin_set))
        {
            return $admin;
        }
        return null;
    }

    function generate_list($group_id)
    {
        global $connection;

        $safe_group_id = mysqli_real_escape_string($connection, $group_id);

        $query = "SELECT * ";
        $query .= "FROM {$safe_group_id} ";

        $player_set = mysqli_query($connection, $query);
        confirm_query($player_set);
        return $player_set;
    }

    function find_admin_by_username($username)
    {
        global $connection;

        $safe_username = mysqli_real_escape_string($connection, $username);

        $query = "SELECT * ";
        $query .= "FROM groups ";
        $query .= "WHERE username = '{$safe_username}' ";
        $query .= "LIMIT 1";
        $username_set = mysqli_query($connection, $query);
        confirm_query($username_set);
        if($current_username = mysqli_fetch_assoc($username_set))
        {
            return $current_username;
        }
        return null;
    }

    function find_player_by_id($player_id)
    {
        global $connection;

        $safe_player_id = mysqli_real_escape_string($connection, $player_id);

        $query = "SELECT * ";
        $query .= "FROM divisionof ";
        $query .= "WHERE id = {$safe_player_id} ";
        $query .= "LIMIT 1";
        $player_set = mysqli_query($connection, $query);
        confirm_query($player_set);
        if($player = mysqli_fetch_assoc($player_set))
        {
            return $player;
        }
        return null;
    }

    function find_selected_player()
    {
        global $current_player;

        if(isset($_GET["player"]))
        {
            $current_player = find_player_by_id($_GET["player"]);
        }
        else
        {
            $current_player = null;
        }
    }

    function navigation($player_array)
    {
        $output = "<ul class=\"players\">";
        $player_set = find_all_players();
        while($player = mysqli_fetch_assoc($player_set))
        {
            $output .= "<li";
            if($player_array && $player['id'] == $player_array['id'])
            {
                $output .= " class=\"selected\"";
            }

            $output .= ">";
            $output .= "<a href=\"manage_content";
            if(!$_SESSION['is_admin'])
            {
                $output .= "_player";
            }
            $output .= ".php?player=";
            $output .= urlencode($player['id']);
            $output .= "\">";
            $output .= htmlentities($player['player_name']);
            $output .= "</a>";
            $output .= "</li>";
        }
        mysqli_free_result($player_set);
        $output .= "</ul>";

        return $output;
    }

    function logout()
    {
        $_SESSION = array();
        if(isset($_COOKIE[session_name()]))
        {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        session_destroy();
    }
?>