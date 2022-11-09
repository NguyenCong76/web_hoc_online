const searchBar = document.querySelector(".search input");
const searchIcon = document.querySelector(".search button");


searchIcon.onclick = function(){
	searchBar.classList.toggle("show");
	searchIcon.classList.toggle("active");
	searchBar.focus();

	if(searchBar.classList.contains("active")){
		searchBar.value = "";
		searchBar.classList.remove("active")
	}
}

searchBar.onkeyup = () => {
	let searchTerm = searchBar.value;
	if(searchTerm !== ""){
		searchBar.classList.add("active");
	} else {
		searchBar.classList.remove("active")
	}

	let xhr = new XMLHttpRequest();
	xhr.open("POST", 'api/search.php', true);
	xhr.onload = () => {
		if((xhr.readyState === XMLHttpRequest.DONE) && (xhr.status === 200)){
			usersList.innerHTML = xhr.response;
		}
	}
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("searchTerm="+searchTerm);
}

