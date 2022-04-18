const dropbtn = document.querySelector('.dropbtn')
const dropdownResources = document.querySelector('.dropdown-resources')
dropdownResources.addEventListener('mouseover', () => {
	dropbtn.style.color = 'hsl(215, 20%, 65%)'
})
dropdownResources.addEventListener('mouseout', () => {
	dropbtn.style.color = 'hsl(210, 40%, 98%)'
})
