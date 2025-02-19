//add new data
function add_user_form(){
	$.ajax({
		type:"POST",
		url:"process.php",
		data:$("#add_user_form").serialize(),
		success:function(data){
			
			//close modal
			$(".close").trigger("click");
			
			//show result
			alert(data);
			
			//reload page
			location.reload();
		}
	});
	return false;
}

//show data for edit
function show_edit_user(id){
	$.ajax({
		type:"POST",
		url:"process.php",
		data:{show_user_id:id},
		success:function(data){
			$("#edit_form").html(data);
		}
	});
	return false;
}

//edit data
function edit_user_form(){
	$.ajax({
		type:"POST",
		url:"process.php",
		data:$("#edit_user_form").serialize(),
		success:function(data){
			
			//close modal
			$(".close").trigger("click");
			
			//show result
			alert(data);
			
			//reload page
			location.reload();
		}
	});
	return false;
}

//delete user
function delete_user(id){
	if(confirm("คุณต้องการลบข้อมูลหรือไม่")){
		$.ajax({
			type:"POST",
			url:"process.php",
			data:{delete_user_id:id},
			success:function(data){
				alert(data);
				location.reload();
			}
		});
	}
	return false;
}