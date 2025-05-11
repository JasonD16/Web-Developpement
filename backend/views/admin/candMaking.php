<?php
$cand = '';
$cand = <<<HTHT
    <form action="/Elections/ballot/add" 
        method="post"
        enctype="multipart/form-data">
    HTHT;
foreach($names as $name)
{
    $n = ucwords("{$name['name']} {$name['middle_name']} {$name['family_name']}");
    $n1 = strtolower($n);
    $mun = strtolower($name['municipality']);
    $cand .= <<<HTHT
    <li class="candidates_options">
          {$n}
          <a class="buttons" href="/Elections/cand/delete/{$mun}/{$n1}">Delete</a>
          <a class="buttons" href="/Elections/admin/showEdit">Edit</a>
            <span class="votes">votes</span
            ><input class="ballot_input_window" type="number" name="ballot[]" value="0" />
        </li>
HTHT;
}
$cand .= <<<HTHT
    <input type="text" name="mun" value="{$mun}" hidden/>
    <li class="candidates_options">Blanks
    <input class="ballot_input_window" type="number" name="ballot[]" value="0" />
    </li>
    <input class="Add_Ballot_submit" type="submit" value="Add Ballot" />
    </form>
    HTHT;

?>