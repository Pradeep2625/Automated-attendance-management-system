<div class="wrapper">
<div class="header">
            <img src="1.jpg" height="100%" width="100%"/>
            </div>
<div class="dropdown">
    <ul class="dropdown">
        <li><a tabindex="-1" href="#">HTML</a></li>
        <li><a tabindex="-1" href="#">CSS</a></li>
        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Tutorials
        <span class="caret"></span></button>
        <ul class="dropdown-menu">
             <li><a tabindex="-1" href="#">HTML</a></li>
            <li><a tabindex="-1" href="#">CSS</a></li>
            <li class="dropdown-submenu">
                <a class="test" tabindex="-1" href="#">New dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu">
                <li><a tabindex="-1" href="#">2nd level dropdown</a></li>
                <li><a tabindex="-1" href="#">2nd level dropdown</a></li>
                <li class="dropdown-submenu">
                    <a class="test" href="#">Another dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">3rd level dropdown</a></li>
                        <li><a href="#">3rd level dropdown</a></li>
                    </ul>
                </li>
                </ul>
            </li>
    </ul>
    </ul>
  </div>
</div>
</div>

<script>
$(document).ready(function(){
  $('.dropdown-submenu a.test').on("click", function(e){
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });
});
</script>