<?php

namespace App\Helpers;

class CategoryIconHelper
{
    /**
     * Get SVG icon for a category
     *
     * @param string $categoryName
     * @param string $class
     * @return string
     */
    public static function getIcon(string $categoryName, string $class = 'w-6 h-6'): string
    {
        $icons = [
            'shirt' => '<svg class="' . $class . '" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7L6 4H9C9 4.39397 9.0776 4.78407 9.22836 5.14805C9.37913 5.51203 9.6001 5.84274 9.87868 6.12132C10.1573 6.3999 10.488 6.62087 10.8519 6.77164C11.2159 6.9224 11.606 7 12 7C12.394 7 12.7841 6.9224 13.1481 6.77164C13.512 6.62087 13.8427 6.3999 14.1213 6.12132C14.3999 5.84274 14.6209 5.51203 14.7716 5.14805C14.9224 4.78407 15 4.39397 15 4H18L21 7L20.5785 11.2152C20.542 11.5801 20.1382 11.7829 19.8237 11.5942L18 10.5V18C18 19.1046 17.1046 20 16 20H8C6.89543 20 6 19.1046 6 18V10.5L4.17629 11.5942C3.86184 11.7829 3.45801 11.5801 3.42152 11.2152L3 7Z" />
            </svg>',

            'short' => '<svg class="' . $class . '" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17,3H7C5.3,3,4,4.3,4,6v1L3.2,17.8C3.1,18.6,3.4,19.4,4,20s1.4,1,2.2,1h2.3c1.3,0,2.5-0.9,2.9-2.2l0.6-2.2l0.6,2.2   c0.4,1.3,1.6,2.2,2.9,2.2h2.3c0.8,0,1.6-0.4,2.2-1s0.9-1.4,0.8-2.3L20,7V6C20,4.3,18.7,3,17,3z M7,5h10c0.6,0,1,0.4,1,1H6   C6,5.4,6.4,5,7,5z M18.6,18.7c-0.2,0.2-0.5,0.3-0.7,0.3h-2.3c-0.4,0-0.8-0.3-1-0.7L13,12.7c-0.1-0.4-0.5-0.7-1-0.7s-0.8,0.3-1,0.7   l-1.6,5.5c-0.1,0.4-0.5,0.7-1,0.7H6.2c-0.3,0-0.5-0.1-0.7-0.3c-0.2-0.2-0.3-0.5-0.3-0.8L5.9,8h3.7L9.3,8.3c-0.4,0.4-0.4,1,0,1.4   s1,0.4,1.4,0L12,8.4l1.3,1.3C13.5,9.9,13.7,10,14,10s0.5-0.1,0.7-0.3c0.4-0.4,0.4-1,0-1.4L14.4,8h3.7l0.8,9.9   C18.8,18.2,18.8,18.5,18.6,18.7z" />
            </svg>',

            'shoe' => '<svg class="' . $class . '" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.5,7a9.97,9.97,0,0,1-1.315-.948L6.01,3.221a.558.558,0,0,0-1,.279H5V5H3.209a.5.5,0,0,1-.357-.148S2.5,4,2,4H1.5a.5.5,0,0,0-.5.5V9H6.5c1.5,0,2,1,3.5,1h4V9.5C14,8,10.547,7.594,9.5,7Zm0,4a3.131,3.131,0,0,1-1.526-.447A4.1,4.1,0,0,0,6,10H1v1.5a.5.5,0,0,0,.5.5h4a.5.5,0,0,0,.5-.5V11a3.134,3.134,0,0,1,1.526.447A4.1,4.1,0,0,0,9.5,12h4a.5.5,0,0,0,.5-.5V11Z" />
            </svg>',

            'trouser' => '<svg class="' . $class . '" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22.5,4H16H9.5L4,28h6.5L15,14c0.3-0.9,1.6-0.9,1.9,0l4.5,14H28L22.5,4z" />
                <line class="st0" x1="16" y1="9" x2="16" y2="4"/>
<rect x="-144" y="-648" class="st3" width="536" height="680"/>
            </svg>',

            'hat' => '<svg class="' . $class . '" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 32 32" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M26.9,8.8c-0.4-0.4-1-0.3-1.4,0.1c-0.4,0.4-0.3,1,0.1,1.4c0,0,2.4,2.2,2.4,5.3V21h-1.8l0.6-3.8c0.5-2.9-0.6-5.9-2.9-7.7
	l-0.2-0.2c-3.1-2.5-7.3-3-11-1.4c-1.5,0.7-2.6,1.9-3.2,3.5l-1.2,3.5c3.4,0.8,6.7,1.9,9.9,3.1c0.5,0.2,0.8,0.8,0.6,1.3
	c-0.2,0.4-0.5,0.6-0.9,0.6c-0.1,0-0.2,0-0.4-0.1c-3.3-1.3-6.8-2.4-10.2-3.2l-4.8,3.4c-0.4,0.3-0.5,0.8-0.3,1.2
	c0.2,0.4,0.7,0.7,1.1,0.6c1.7-0.3,3.5,0,5,0.9l4.2,2.7c1.5,1,3.2,1.4,4.9,1.4c2.4,0,4.7-0.9,6.4-2.6l1.4-1.4H29c0.6,0,1-0.4,1-1
	v-6.3C30,11.6,27,9,26.9,8.8z" />
            </svg>',

            'jacket' => '<svg class="' . $class . '" xmlns="http://www.w3.org/2000/svg" fill="#000000" viewBox="0 0 490 490" stroke="currentColor">
                <path  stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M468.185,158.872c-0.26-0.23-0.527-0.452-0.802-0.664L350,67.628V15c0-8.284-6.716-15-15-15H155
	c-8.284,0-15,6.716-15,15v52.628l-117.383,90.58c-0.274,0.212-0.542,0.434-0.802,0.664C7.951,171.196,0,188.903,0,207.453V345
	c0,8.284,6.716,15,15,15h5v55c0,8.284,6.716,15,15,15h55v45c0,8.284,6.716,15,15,15h280c8.284,0,15-6.716,15-15v-45h55
	c8.284,0,15-6.716,15-15v-55h5c8.284,0,15-6.716,15-15V207.453C490,188.903,482.049,171.196,468.185,158.872z M260,30h60v30h-60V30z
	 M90,400H50v-40h40V400z M230,460H120V345.35c0.003-0.115,0.004-0.23,0.004-0.346v-140c0-8.284-6.716-15-15-15s-15,6.716-15,15V330
	H30V207.453c0-9.83,4.147-19.221,11.395-25.842L160.114,90H230V460z M230,60h-60V30h60V60z M440,400h-40v-40h40V400z M460,330
	h-59.996V205.004c0-8.284-6.716-15-15-15s-15,6.716-15,15v139.65C370.001,344.77,370,344.885,370,345v115H260V90h69.886
	l118.72,91.611c7.247,6.621,11.395,16.012,11.395,25.842V330z" />
            </svg>',
        ];

        $lowerCategoryName = strtolower($categoryName);

        return $icons[$lowerCategoryName] ?? '<svg class="' . $class . '" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
        </svg>';
    }
}
