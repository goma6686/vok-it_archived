const containers = document.querySelectorAll(".hideableElement");

containers.forEach(container => {
	if(container.childElementCount < 2) {
		container.classList.add("hiddenObject");
	}
});