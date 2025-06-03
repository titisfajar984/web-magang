document.addEventListener('DOMContentLoaded', () => {
  const menuToggle = document.getElementById('menu-toggle');
	const menuNavigation = document.getElementById('menu-navigation');
	const menuClose = document.getElementById('menu-close');

	if (window.innerWidth < 640) menuNavigation.dataset.open = "false";

	const isMenuOpen = () => menuNavigation.dataset.open === "true";

	const updateNavigation = () => {
		if (isMenuOpen()) {
			menuNavigation.classList.remove('-left-full');
			menuNavigation.classList.add('left-0');
			if (window.innerWidth > 640) {
				menuNavigation.classList.remove('absolute');
			} else {
				menuNavigation.classList.add('absolute');
			}
		} else {
			menuNavigation.classList.add('absolute');
			menuNavigation.classList.remove('left-0');
			menuNavigation.classList.add('-left-full');
		}
	};

	menuToggle.addEventListener('click', (e) => {
		e.stopPropagation();
		menuNavigation.dataset.open = isMenuOpen() ? "false" : "true";
		updateNavigation();
	});

	menuClose.addEventListener('click', () => {
		menuNavigation.dataset.open = "false";
		updateNavigation();
	});

	window.addEventListener('resize', () => {
		if (window.innerWidth < 640) menuNavigation.dataset.open = "false";
		updateNavigation();
	});

	document.addEventListener('click', (e) => {
		if (
			isMenuOpen() &&
			!menuNavigation.contains(e.target) &&
			!menuToggle.contains(e.target)
		) {
			menuNavigation.dataset.open = "false";
			updateNavigation();
		}
	});

	updateNavigation();
});