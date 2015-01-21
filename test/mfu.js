// $Id: multipleFileUploader.js,v 1.4 2007/03/15 14:31:13 mxt Exp $ 
function multipleFileUploader(elementName) {
	var uploadDivElement = document.createElement('DIV');
	var uploadListElement = document.createElement('OL');
	var uploadCollection = new Array();
	var index;

  var uploadElementOnChange = function() {
		var anchorElement;
		var imageElement;

		index = uploadCollection.length;

		uploadCollection[index] = {'file':null, 'list':null};
		uploadCollection[index].file = this.cloneNode(false);
		uploadCollection[index].file.onkeydown = function() { return false; }
		uploadCollection[index].file.onchange = uploadElementOnChange;
		uploadCollection[index].file.value = '';

		imageElement = document.createElement('IMG');
		imageElement.src = './shared/images/delete.gif';
		imageElement.title = index;
		imageElement.style.border = 'none';

		anchorElement = document.createElement('A');
		anchorElement.appendChild(imageElement);
		anchorElement.href = '#';
		anchorElement.id = elementName + 'Anchor_' + (index-1);
		anchorElement.style.marginLeft = '0.5em';
		anchorElement.onclick = function() {
			var selectedIndex = this.id.split('_').pop();
			uploadDivElement.removeChild(uploadCollection[selectedIndex].file);
			uploadListElement.removeChild(uploadCollection[selectedIndex].list);
			uploadCollection[selectedIndex] = null;
		}

		uploadCollection[index-1].list = document.createElement('LI')
		uploadCollection[index-1].list.appendChild(document.createTextNode(this.value));
		uploadCollection[index-1].list.appendChild(anchorElement);

		uploadListElement.appendChild(uploadCollection[index-1].list);
		uploadDivElement.insertBefore(uploadCollection[index].file, this);
		this.style.display = 'none';
	}

	index = uploadCollection.length;
  uploadCollection[index] = {'file':null, 'list':null};
	uploadCollection[index].file = document.getElementById(elementName);
	uploadCollection[index].file.onkeydown = function() { return false; }
	uploadCollection[index].file.onchange = uploadElementOnChange;
  uploadCollection[index].file.name = uploadCollection[index].file.name + '[]';
	uploadDivElement.id = elementName + 'Div';
	uploadListElement.id = elementName + 'List';
	uploadCollection[index].file.parentNode.appendChild(uploadDivElement);
	uploadCollection[index].file.parentNode.appendChild(uploadListElement);
	uploadDivElement.appendChild(uploadCollection[index].file);
}