export function useGender() {
    const formatGender = (gender) => {
        if (gender === 'MAN') {
            return {
                icon: '✓',
                text: 'Laki-laki',
                class: 'text-blue-600 dark:text-blue-400 dark:bg-dark-default rounded-md px-2 py-1'
            };
        }
        return {
            icon: '✗',
            text: 'Perempuan',
            class: 'text-green-600 dark:text-green-400 dark:bg-dark-default rounded-md px-2 py-1'
        };
    };

    const formatGenderOrientasi = (gender) => {
        if (gender === 'MAN') {
            return {
                icon: '✓',
                text: 'Laki-laki',
                class: 'text-blue-600 dark:text-blue-400 dark:bg-dark-default rounded-md px-2 py-1'
            };
        }
        return {
            icon: '✗',
            text: 'Perempuan',
            class: 'text-green-600 dark:text-green-400 dark:bg-dark-default rounded-md px-2 py-1'
        };
    };

    return {
        formatGender,
        formatGenderOrientasi
    };
} 