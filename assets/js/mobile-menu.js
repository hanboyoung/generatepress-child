/**
 * Mobile Menu Functionality
 * Integrates with GeneratePress parent theme functionality
 */

(function($) {
    $(document).ready(function() {
        initMobileMenu();
        
        // For debugging
        console.log('Mobile menu script loaded and ready');
    });
    
    function initMobileMenu() {
        const menuToggle = $('.menu-toggle');
        const mainNavigation = $('.main-navigation');
        const navMenu = $('.nav-menu, .header-menu');
        const siteHeader = $('.site-header');
        
        console.log('Menu elements found:', {
            'menuToggle exists': menuToggle.length > 0,
            'mainNavigation exists': mainNavigation.length > 0,
            'navMenu exists': navMenu.length > 0,
            'siteHeader exists': siteHeader.length > 0
        });
        
        if (menuToggle.length) {
            // Override any existing click handlers by unbinding first
            menuToggle.off('click');
            
            menuToggle.on('click', function(e) {
                e.preventDefault();
                
                // Toggle classes for visual appearance
                menuToggle.toggleClass('toggled');
                mainNavigation.toggleClass('toggled');
                navMenu.toggleClass('toggled');
                
                // Toggle aria attributes for accessibility
                const expanded = menuToggle.attr('aria-expanded') === 'true' || false;
                menuToggle.attr('aria-expanded', !expanded);
                
                // Apply GeneratePress compatibility
                if (typeof generatepress !== 'undefined' && generatepress.hasOwnProperty('toggleNav')) {
                    // Let GeneratePress handle the menu toggling too
                    // but don't let it override our styles
                    mainNavigation.css('display', 'block');
                }
                
                return false;
            });
            
            // Close menu when clicking outside
            $(document).on('click', function(event) {
                if ((navMenu.hasClass('toggled') || mainNavigation.hasClass('toggled')) && 
                    !mainNavigation.has(event.target).length && 
                    !menuToggle.has(event.target).length && 
                    !$(event.target).is(menuToggle)) {
                    
                    mainNavigation.removeClass('toggled');
                    menuToggle.removeClass('toggled');
                    navMenu.removeClass('toggled');
                    menuToggle.attr('aria-expanded', 'false');
                }
            });
            
            // Close menu when window is resized above mobile breakpoint
            $(window).on('resize', function() {
                if (window.innerWidth > 768 && (navMenu.hasClass('toggled') || mainNavigation.hasClass('toggled'))) {
                    mainNavigation.removeClass('toggled');
                    menuToggle.removeClass('toggled');
                    navMenu.removeClass('toggled');
                    menuToggle.attr('aria-expanded', 'false');
                }
            });
            
            // Handle submenu toggling
            $('.menu-item-has-children > a').on('click', function(e) {
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    
                    const parentLi = $(this).parent();
                    const subMenu = parentLi.find('> .sub-menu');
                    
                    subMenu.toggleClass('toggled-on');
                    
                    return false;
                }
            });
            
            console.log('Mobile menu event listeners initialized');
        } else {
            console.error('Menu toggle button not found. Check your theme structure.');
        }
    }
})(jQuery); 