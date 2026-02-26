const EMPTY = {
    experience: () => ({ company: '', role: '', start_date: '', end_date: '', description: '' }),
    education:  () => ({ school: '', degree: '' }),
    skills:     () => ({ name: '' }),
    languages:  () => ({ name: '', level: '' }),
    projects:   () => ({ title: '', description: '' }),
};

export default function cvForm() {
    return {
        experience: [],
        education:  [],
        skills:     [],
        languages:  [],
        projects:   [],
        photoUrl:   null,

        onPhotoChange(event) {
            const file = event.target.files[0];
            if (file) this.photoUrl = URL.createObjectURL(file);
        },

        add(section) {
            this[section].push(EMPTY[section]());
        },

        remove(section, index) {
            this[section].splice(index, 1);
        },
    };
}
