const containersForDraggables = document.querySelectorAll('.containerForDraggable');
const draggables = document.querySelectorAll('.draggable');
const sortChangeButtons = document.querySelectorAll('.sortBySelectionButton');
const visibilityButtons = document.querySelectorAll(".visibilityToggleButton");

// Adding the listeners

containersForDraggables.forEach(container => { // listener for all containers that house the draggables
	container.addEventListener('dragover', e => {
		addDragoverFunctionality(container, e);
	});
});

draggables.forEach(draggable => { // Listener for all draggable elements
	draggable.addEventListener('dragstart', () => { // listener adds class 'beingDragged' when the div starts being dragged
		draggable.classList.add('beingDragged');
	});
	draggable.addEventListener('dragend', () => { // listener removes class 'beingDragged' when the div stops being dragged
		draggable.classList.remove('beingDragged');
		updateOrderInDatabase(draggable);
	});
});

sortChangeButtons.forEach(button => { // Button listener which changes which tab is being displayed (tab being which sorting list)
	button.addEventListener('click', () => {
		changeSortByHidden(button.id);
	});
});

visibilityButtons.forEach(visibilityButton => {
	visibilityButton.addEventListener('click', () => {

		// Update DB to toggle visibility
		const update_lookup = '_token=' + csrfToken;
		if(window.XMLHttpRequest) {
	    	update_xmlhttp = new XMLHttpRequest();
	    } else {
	    	update_xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	    }
	    const id = visibilityButton.parentElement.parentElement.id;
	    update_xmlhttp.open("POST", '/administrator/updateVisibility/' + id, true);
    	update_xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    	update_xmlhttp.send(update_lookup);

    	// Toggle eye
    	if(visibilityButton.children[0].classList.contains("bi-eye-slash")) {
    		visibilityButton.children[0].classList.remove("bi-eye-slash");
    		visibilityButton.children[0].classList.add("bi-eye");
    	} else {
    		visibilityButton.children[0].classList.remove("bi-eye");
    		visibilityButton.children[0].classList.add("bi-eye-slash");
    	}

    	// Toggle eye in other sorts
    	if(visibilityButton.classList[2] != "category") {
    		updateVisibilityOther("category", id);
    	}
    	if(visibilityButton.classList[2] != "topic") {
    		updateVisibilityOther("topic", id);
    	}
    	if(visibilityButton.classList[2] != "level") {
    		updateVisibilityOther("level", id);
    	}
	});
});

// Supporting functions 

function addDragoverFunctionality(container, e) {
	const afterElement = [...container.querySelectorAll('.draggable:not(.beingDragged)')].reduce((closest, child) => { // the following code gets the element that would be next after the element that is currently being dragged (if it itself is the last element, then this is NULL)
		const box = child.getBoundingClientRect();
		const offset = e.clientY - box.top - box.height / 2;
		if(offset < 0 && offset > closest.offset) {
			return {offset: offset, element: child};
		} else {
			return closest;
		}
	}, { offset: Number.NEGATIVE_INFINITY }).element;

	e.preventDefault(); // changes the mouse cursor (goes from stop symbol to "element selected and can be dropped")
	const beingDragged = document.querySelector('.beingDragged');
	if(beingDragged !== null) {
		if(afterElement == null) {
			container.appendChild(beingDragged);
		} else {
			container.insertBefore(beingDragged, afterElement);
		}
	}
}

function changeSortByHidden(dontHide) { // Shows/Hides tabs based on button
	const containerOfContainers = document.querySelectorAll('.containersContainer');
	containerOfContainers.forEach(containerContainer => {
		containerContainer.classList.add('hiddenSort');
	});
	document.querySelector('.' + dontHide + '.hiddenSort').classList.remove('hiddenSort');
}

function updateOrderInDatabase(draggable) { // Handles updating category/topic/level in real time to the database and in the classes

	var updateDatabase = [];
	var length;

	const sortingBy = draggable.classList[1];
    const previousContainerId = draggable.classList[2];
    const previousContainerPos = draggable.classList[3];

    const currentContainerId = draggable.parentElement.id;
    const elementBeforeDraggable = draggable.previousElementSibling;

    let currentContainerPos;   
    if(!isNaN(currentContainerId)) {
    	if(elementBeforeDraggable.classList[0] != "container_name") {
    		currentContainerPos = "containerPos_" + (+elementBeforeDraggable.classList[3].split('_')[1] + 1);
    	} else {
    		currentContainerPos = "containerPos_1";
    	}
    } else {
    	currentContainerPos = "containerPos_noPos";
    }

    // If the element moved to a different container or a different position (in any container other than the unsorted one)
    if(previousContainerId.split('_')[1] != currentContainerId || previousContainerPos != currentContainerPos) {

    	// Update container (in HTML)
	    draggable.classList.replace(draggable.classList[2], "containerId_" + currentContainerId);

	    // Update position (in HTML)
	    draggable.classList.replace(draggable.classList[3], currentContainerPos);

	    // Add new position to array to send by POST
	    length = Object.keys(updateDatabase).length;
	    updateDatabase[length] = {};
	    updateDatabase[length].id = draggable.id;
	    updateDatabase[length].sortingBy = sortingBy;
	    updateDatabase[length].parentId = currentContainerId;
	    updateDatabase[length].newPos = currentContainerPos.split('_')[1];

	    // Update the positions of all elements after this one (in HTML)
	    if(!isNaN(currentContainerId)) {
	    	let workingOn = draggable.nextElementSibling;
		    while(workingOn !== null) {
		    	workingOn.classList.replace(workingOn.classList[3], "containerPos_" + (+workingOn.classList[3].split('_')[1] + 1));

		    	length = Object.keys(updateDatabase).length;
		    	updateDatabase[length] = {};
			    updateDatabase[length].id = workingOn.id;
			    updateDatabase[length].sortingBy = sortingBy;
			    updateDatabase[length].parentId = workingOn.classList[2].split('_')[1];
			    updateDatabase[length].newPos = workingOn.classList[3].split('_')[1];

		    	workingOn = workingOn.nextElementSibling;
		    }
	    }

	    // Update the posion of all elements from previous container
	    if(!isNaN(previousContainerId.split('_')[1])) {
	    	let workingOn = document.querySelector("." + previousContainerId + ".containerPos_" + (+previousContainerPos.split('_')[1] + 1));
	    	while(workingOn !== null) {
	    		workingOn.classList.replace(workingOn.classList[3], "containerPos_" + (+workingOn.classList[3].split('_')[1] - 1));

	    		length = Object.keys(updateDatabase).length;
		    	updateDatabase[length] = {};
			    updateDatabase[length].id = workingOn.id;
			    updateDatabase[length].sortingBy = sortingBy;
			    updateDatabase[length].parentId = workingOn.classList[2].split('_')[1];
			    updateDatabase[length].newPos = workingOn.classList[3].split('_')[1];

	    		workingOn = workingOn.nextElementSibling;
	    	}
	    }
    }

    const update_lookup = 'update=' + JSON.stringify(updateDatabase) + '&_token=' + csrfToken;
    if(window.XMLHttpRequest) {
    	update_xmlhttp = new XMLHttpRequest();
    } else {
    	update_xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    update_xmlhttp.open("POST", '/administrator/updatePos', true);
    update_xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //update_xmlhttp.setRequestHeader("Content-length", update_lookup.length);
    //update_xmlhttp.setRequestHeader("Connection", "close");
    update_xmlhttp.send(update_lookup);
}

function updateVisibilityOther(sortBy, id) {

	const otherVisibilityToggleButtons = document.querySelectorAll("." + sortBy + ".visibilityToggleButton");
	for(var i = 0; i < otherVisibilityToggleButtons.length; i++) {
		if(otherVisibilityToggleButtons[i].parentElement.parentElement.id == id) {
	    	if(otherVisibilityToggleButtons[i].children[0].classList.contains("bi-eye-slash")) {
	    		otherVisibilityToggleButtons[i].children[0].classList.remove("bi-eye-slash");
	    		otherVisibilityToggleButtons[i].children[0].classList.add("bi-eye");
	    	} else {
	    		otherVisibilityToggleButtons[i].children[0].classList.remove("bi-eye");
	    		otherVisibilityToggleButtons[i].children[0].classList.add("bi-eye-slash");
	    	}
			break;
		}
	}
}

/*checkboxes.forEach(checkbox => {
	checkbox.addEventListener('change', function() {

		const update_lookup = '_token=' + csrfToken; 
		if(window.XMLHttpRequest) {
	    	update_xmlhttp = new XMLHttpRequest();
	    } else {
	    	update_xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	    }
	    const id = checkbox.parentElement.parentElement.parentElement.id;
	    update_xmlhttp.open("POST", '/administrator/updateVisibility/' + id, true);
    	update_xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    	update_xmlhttp.send(update_lookup);

    	const checked = checkbox.checked;
    	if(checkbox.parentElement.parentElement.parentElement.classList[1] != "category") {
    		updateVissibilityHTML("category", id);
    	}
    	if(checkbox.parentElement.parentElement.parentElement.classList[1] != "topic") {
    		updateVissibilityHTML("topic", id);
    	}
    	if(checkbox.parentElement.parentElement.parentElement.classList[1] != "level") {
    		updateVissibilityHTML("level", id);
    	}


    	const elementInCategoryContainer = document.querySelectorAll(".draggable.category");
    	const elementInTopicContainer = document.querySelectorAll(".draggable.topic");
    	const elementInLevelContainer = document.querySelectorAll(".draggable.level");

	});
});

function updateVissibilityHTML(sortBy, id) {
	const elementList = document.querySelectorAll(".draggable." + sortBy);
	for(var i = 0; i < elementList.length; i++) {
		if(elementList[i].id == id) {
			for(var j = 0; j < elementList[i].childNodes.length; j++) {
				if(elementList[i].childNodes.classList.length > 1) {
					if((elementList[i].childNodes.classList[0] == "form-check") && (elementList[i].childNodes.classList[0] == "form-switch")) {
						
					}
				}
			}
			break;
		}
	}
}*/

/*const switchButtons = document.querySelectorAll('.sortBySelectionButton');

// 'containerForDraggable' that has the id 'noId' Listener (it's contents are dynamic but it itself is static so its listener only needs to be added once)
document.getElementById('noId').addEventListener('dragover', e => {
	addDragoverFunctionality(document.getElementById('noId'), e);
});

// SwitchButton Listeners
switchButtons.forEach(switchButton => {
	switchButton.addEventListener("click", () => {

		// Clear containers that have id's 'withId' and 'noId'
		document.querySelector('.containerForContainerForDraggable').innerHTML = '';
		document.getElementById('noId').innerHTML = '';

		// Add div to house the name for 'noId' container
		const name = document.createElement('div');
		name.innerHTML = unsortedName; // Set correct name based on current page language
		document.getElementById('noId').appendChild(name);

		// Add containers into 'containerForContainerForDraggable' that can handle draggables
		switch(switchButton.id) {
			case 'category':
				categories.forEach( function(category, i) {
					generateContainers(category.name, category.name_de, i);
				});
				break;
			case 'topic':
				topics.forEach( function(topic, i) {
					generateContainers(topic.name, topic.name_de, i);
				});
				break;
			case 'level':
				levels.forEach( function(level, i) {
					generateContainers(level.name, level.name_de, i);
				});
				break;
		}


		// Add containers into 'containerForContainerForDraggable' that can handle draggables
		// Add elements into containers
		switch(switchButton.id) {
			case 'category':
				categories.forEach( function(category, i) {
					createContainer(category.name, category.name_de, "category", i);
				});
				lessons.forEach( function(lesson, i) {
					createDraggable(lesson.id, switchButton.id, lesson.category_id, i);
				});
				break;
			case 'topic':
				topics.forEach( function(topic, i) {
					createContainer(topic.name, topic.name_de, "topic", i);
				});
				lessons.forEach( function(lesson, i) {
					createDraggable(lesson.id, switchButton.id, lesson.topic_id, i);
				});
				break;
			case 'level':
				levels.forEach( function(level, i) {
					createContainer(level.name, level.name_de, "level", i);
				});
				lessons.forEach( function(lesson, i) {
					createDraggable(lesson.id, switchButton.id, lesson.level_id, i);
				});
				break;
		}
	})
});

// Generates containers for all categories/topics/levels
function generateContainers(containerName_LT, containerName_DE, arrayPos) { 
	const contanerForMovables = document.createElement('div');
	contanerForMovables.classList.add('containerForDraggable');
	contanerForMovables.classList.add("container_" + (arrayPos + 1));
	contanerForMovables.id = containerName_LT;
	contanerForMovables.addEventListener('dragover', e => {
		addDragoverFunctionality(contanerForMovables, e);
	});
	const name = document.createElement('div');
	if(language=="DE") { // Name set based on current page language
		name.innerHTML=containerName_DE;
	} else {
		name.innerHTML=containerName_LT;
	}
	contanerForMovables.appendChild(name);
	document.querySelector('.containerForContainerForDraggable').appendChild(contanerForMovables);
}

// Adds the visual functionality of how the containers react when a draggable is being dragged over them
function addDragoverFunctionality(container, e) {
	const afterElement = [...container.querySelectorAll('.draggable:not(.beingDragged)')].reduce((closest, child) => { // the following code gets the element that would be next after the element that is currently being dragged (if it itself is the last element, then this is NULL)
		const box = child.getBoundingClientRect();
		const offset = e.clientY - box.top - box.height / 2;
		if(offset < 0 && offset > closest.offset) {
			return {offset: offset, element: child};
		} else {
			return closest;
		}
	}, { offset: Number.NEGATIVE_INFINITY }).element;

	e.preventDefault(); // changes the mouse cursor (goes from stop symbol to "element selected and can be dropped")
	const beingDragged = document.querySelector('.beingDragged');
	if(beingDragged !== null) {
		if(afterElement == null) {
			container.appendChild(beingDragged);
		} else {
			container.insertBefore(beingDragged, afterElement);
		}
	}
}

function generateDraggables() {

	// An array that will hold all of the lessons
	let draggables = [];

	lessons.forEach( lesson => {
		// Create new div
		const draggable = document.createElement('div');

		// Add it's classes
		draggable.classList.add('draggable'); // class used by the addDragoverFunctionality function
		switch(switchButton.id) {
			case 'category':
				draggable.classList.add('container_' + lesson.category_id);
				draggable.classList.add('posInContainer_' + lesson.category_order);
				break;
			case 'topic':
				draggable.classList.add('container_' + lesson.topic_id);
				draggable.classList.add('posInContainer_' + lesson.topic_order);
				break;
			case 'level':
				draggable.classList.add('container_' + lesson.level_id);
				draggable.classList.add('posInContainer_' + lesson.level_order);
				break;
		}

		// Add the Lessons id from the database
		draggable.id = lesson.id;

		// Set the property of draggable
		draggable.draggable = true;

		// Add event listeners
		draggable.addEventListener('dragstart', () => { // listener adds class 'beingDragged' when the div starts being dragged
		draggable.classList.add('beingDragged');
		});
		draggable.addEventListener('dragend', () => { // listener removes class 'beingDragged' when the div stops being dragged
			draggable.classList.remove('beingDragged');
			updateDatabaseIfContainerChanged(draggable);
		});

		// Fill content of div
		fillDraggableInnerHTML(draggable, lesson);

		// Add the div to the array of all draggables
		draggables.push(draggable);
	});

	// Adds the draggables into the generated containers
	addDraggablesToContainers(draggables);
}

function fillDraggableInnerHTML(draggable, lesson) {

	const name = document.createElement('div');
	name.innerHTML = lesson.name;
	name.classList.add('name');
	draggable.appendChild(name);
	const description = document.createElement('div');
	description.innerHTML = lesson.description;
	description.classList.add('description');
	draggable.appendChild(description);
	const format = document.createElement('div');
	format.innerHTML = lesson.format;
	format.classList.add('format');
	draggable.appendChild(format);
}

function addDraggablesToContainers(draggables) {



	let pointer = 0;
	while(draggables.length - 1 > 0) {

		// If pointer is larger than array size, we have looped through the array and start from the beggining
		if(pointer > draggables.length - 1) {
			pointer = 0;
		}

		draggables[pointer]
	}
}






function createDraggable(lessonId, buttonId, lessonSortId, arrayPos, posWithinContainer) {
	const draggable = document.createElement('div'); // create a div
	fillDraggableContents(draggable, arrayPos); // fills the div contents
	draggable.classList.add('draggable');  // adds 'draggable' to the class list (this is used in the getDragAfterElement function)
	draggable.classList.add(buttonId+'_'+lessonSortId); // adds what is it being sorted by (categories/topics/levels) followed by '_' and then the id of that element eg.: (topic_2) <-- sorting by topic and the lesson is set to be topic id 2
	draggable.classList.add('pos_' + posWithinContainer); // adds in which position is it within the container
	draggable.id = lessonId; // adds lessons id (from DB)
	draggable.draggable = true; // sets the property of the div to be allowed to be dragged
	draggable.addEventListener('dragstart', () => { // listener adds class 'beingDragged' when the div starts being dragged
		draggable.classList.add('beingDragged');
	});
	draggable.addEventListener('dragend', () => { // listener removes class 'beingDragged' when the div stops being dragged
		draggable.classList.remove('beingDragged');
		updateDatabaseIfContainerChanged(draggable);
	});
	if(lessonSortId) { // check if the category/topic/level id of the lesson is NULL or not and add it to the correct div
		switch(buttonId) {
			case 'category':
				document.getElementById(categories[lessonSortId-1].name).insertBefore(draggable, document.getElementById);
				break;
			case 'topic':
				document.getElementById(topics[lessonSortId-1].name).appendChild(draggable);
				break;
			case 'level':
				document.getElementById(levels[lessonSortId-1].name).appendChild(draggable);
				break;
		}
	} else {
		document.getElementById('noId').appendChild(draggable);
	}
}

function updateDatabaseIfContainerChanged(draggable) {
	const sortingBy = draggable.classList[1].split('_')[0];
    const previousContainerId = draggable.classList[1].split('_')[1];
    const currentContainerId = draggable.parentElement.classList[1].split('_')[1];

    var update_lookup = 'sortBy=' + encodeURIComponent(sortingBy) + '&prevId=' + encodeURIComponent(previousContainerId) + '&newId=' + encodeURIComponent(currentContainerId) + '&lessonId=' + encodeURIComponent(draggable.id) + '&_token=' + csrfToken;
    if(window.XMLHttpRequest) {
    	update_xmlhttp = new XMLHttpRequest();
    } else {
    	update_xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    update_xmlhttp.onreadystatechange = function() {
    	if(update_xmlhttp.readyState == 4 && update_xmlhttp.status == 200) {
    		console.log(update_xmlhttp.responseText); // <---- Extra JS that gets run after route established?
    	}
    }
    update_xmlhttp.open("POST", '/administrator/updatePos', true);
    update_xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //update_xmlhttp.setRequestHeader("Content-length", update_lookup.length);
    //update_xmlhttp.setRequestHeader("Connection", "close");
    update_xmlhttp.send(update_lookup);
}*/