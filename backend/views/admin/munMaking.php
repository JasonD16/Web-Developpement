<?php

foreach($names as $name)
		{
			$name = ucwords($name['name']);
			$mun .= <<<HTHT
					<li class="mun_options">
					{$name}<a class="buttons" href="/Elections/mun/delete/{$name}">Delete</a
					><a class="buttons" href="/Elections/admin/edit/{$name}">Edit</a>
					<a class="buttons" href="/Elections/admin/showCand/{$name}">Candidates</a>
					</li>
					HTHT;
		}

?>