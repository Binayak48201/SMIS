function numerics()
{
		$(".numeric").numeric();
}

function integer()
{
		$(".integer").numeric(false, function() { alert("Integers only"); this.value = ""; this.focus(); });
}

function positive()
{
  	$(".positive").numeric({ negative: false }, function() { alert("No negative values"); this.value = ""; this.focus(); });
}

function positive_integer()
{
  	$(".positive-integer").numeric({ decimal: false, negative: false }, function() { alert("Positive integers only"); this.value = ""; this.focus(); });
}

function decimal()
{
  	$(".decimal-2-places").numeric({ decimalPlaces: 2 });
}

