<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8"> 
</head>
<body onload="loadDoc()">

<script>
	function loadDoc(url) {
		var today = new Date();
		var dd = String(today.getDate()).padStart(2, '0');
		var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
		var yyyy = today.getFullYear();

		today = yyyy + '-' + mm + '-' + dd;
		//console.log(today);

		var max_person1;
		var max_person2;
		var max_days = 0;
		var xhttp;
		var i;
		var j;
		var date_start;
		var date_end;

		xhttp=new XMLHttpRequest();
		xhttp.open("GET", 'data.txt', true);
		xhttp.send();

		xhttp.onreadystatechange = function() {
		    if (this.readyState == 4 && this.status == 200) {
				//console.log(this);
				
				var text = this.responseText;
				var a_row = text.split("\r\n");
				//console.log(a_row);

				for(i = 0; i < a_row.length-1; i++){
					var a_column = a_row[i].split(", ");
					var person1 = a_column[0];
					var person1_project = a_column[1];
					var person1_start = a_column[2];
					var person1_end = a_column[3];

					if(person1_end == "NULL" || typeof person1_end === "undefined" || person1_end === null){
						person1_end = today;
					}

					for(j = i+1; j < a_row.length; j++){
						var a_column2 = a_row[j].split(", ");
						var person2 = a_column2[0];
						var person2_project = a_column2[1];
						var person2_start = a_column2[2];
						var person2_end = a_column2[3];

						if(person2_end == "NULL" || typeof person2_end === "undefined" || person2_end === null){
							person2_end = today;
						}
						//console.log(person1 + " - " + person2);

						if(person1 != person2){
							if(person1_project == person2_project){
								//console.log(person1 + " - " + person2);
								if(person1_start < person2_end && person2_start < person1_end){
									if(person1_start < person2_start){
										date_start = person2_start;
									} else {
										date_start = person1_start;
									}

									//console.log(person1_start + " - " + person2_start + " > " + date_start);

									if(person1_end > person2_end){
										date_end = person2_end;
									} else {
										date_end = person1_end;
									}

									//console.log(person1_end + " - " + person2_end + " < " + date_end);
									//console.log(date_start);
									//console.log(date_end);

									var day_start = date_start.substr(8, 2);
									var month_start = date_start.substr(5, 2);
									var year_start = date_start.substr(0, 4);

									var day_end = date_end.substr(8, 2);
									var month_end = date_end.substr(5, 2);
									var year_end = date_end.substr(0, 4);

									var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
									var firstDate = new Date(year_start, month_start, day_start);
									var secondDate = new Date(year_end, month_end, day_end);
									var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
									//console.log(diffDays);

									if(diffDays > max_days){
										max_days = diffDays;
										max_person1 = person1;
										max_person2 = person2;
									}
								}
							}
						}
					}
				}
				
				//console.log(max_days);
				console.log(max_person1 + " " + max_person2);
				
				
		    }
		};
		
	}
</script>
</body>