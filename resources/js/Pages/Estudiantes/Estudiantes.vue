<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {usePage} from '@inertiajs/vue3';
import {Head} from '@inertiajs/vue3';
import {ref} from 'vue';
import axios from 'axios';


const page = usePage();
const estudiantes = page.props.estudiantes;



const isModalOpen = ref(false);
const editandoEstudiante = ref(null);

const form = ref({
    nombre: '',
    correo: '',
    nctrl: '',
    id: null,
});


const openModal = (estudiante = null) => {
    if (estudiante) {
        editandoEstudiante.value = estudiante;
        form.value = { ...estudiante };
    } else {
        editandoEstudiante.value = null;
        form.value = { nombre: '', correo: '', nctrl: '', id: null };
    }
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    form.value = { nombre: '', correo: '', nctrl: '', id: null };
    editandoEstudiante.value = null;
};

const guardarEstudiante = async () => {
    try {
        if (form.value.id) {
            await axios.post(route('estudiantes.update', form.value.id), form.value);
            alert('Estudiante actualizado correctamente');
        } else {
            await axios.post(route('estudiantes.store'), form.value);
            alert('Estudiante registrado correctamente');
        }
        window.location.href = route('estudiantes');
        closeModal();
    } catch (error) {
        console.error('Error al guardar:', error);
        alert('Hubo un error al guardar el estudiante.');
    }
};

const eliminarEstudiante = async (id) => {
    try {
        if (confirm('¿Estás seguro de que deseas eliminar este estudiante?')) {
            await axios.delete(route('estudiantes.destroy', id));
            alert('Estudiante eliminado correctamente');
            window.location.href = route('estudiantes');
        }
    } catch (error) {
        console.error('Error al eliminar:', error);
        alert('Hubo un error al eliminar el estudiante.');
    }
};

</script>

<template>
    <Head title="Estudiantes"/>

    <AuthenticatedLayout>
        <template #header>

            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Lista de Estudiantes
            </h2>
        </template>

        <div class="py-4">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-3 text-gray-900">
                        <button @click="openModal" class="px-4 py-3 bg-amber-500 text-white rounded hover:bg-amber-200">
                            + Agregar Estudiante
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-4">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div v-if="Object. keys( estudiantes ). length !== 0">
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nombre</th>
                                    <th scope="col" class="px-6 py-3">Correo</th>
                                    <th scope="col" class="px-6 py-3">Nctrl</th>
                                    <th scope="col" class="px-6 py-3">Actualizar</th>
                                    <th scope="col" class="px-6 py-3">Eliminar</th>
                                    <th scope="col" class="px-6 py-3">Certificaciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="estudiante in estudiantes" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" >
                                    <th scope="col" class="px-6 py-3">{{ estudiante.nombre }}</th>
                                    <th scope="col" class="px-6 py-3">{{ estudiante.correo }}</th>
                                    <th scope="col" class="px-6 py-3">{{ estudiante.nctrl }}</th>
                                    <th scope="col" class="px-6 py-3"> <button @click="openModal(estudiante)" class="px-4 py-3 bg-amber-500 text-white rounded hover:bg-amber-200">
                                        Editar
                                    </button></th>
                                    <th scope="col" class="px-6 py-3"><button @click="eliminarEstudiante(estudiante.id)" class="px-4 py-3 bg-red-500 text-white rounded hover:bg-red-600">
                                        Eliminar
                                    </button></th>
                                    <th scope="col" class="px-6 py-3">
                                        <a
                                            :href="route('certificaciones_estudiante', estudiante.id)"
                                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors duration-200"
                                        >
                                            Admin cursos.
                                        </a>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div v-else>
                        <p>No hay estudiantes registrados.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal New-->
        <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                <h3 class="text-lg font-bold mb-4">{{ editandoEstudiante.value ? 'Nuevo Estudiante' : '' }}</h3>

                <form @submit.prevent="guardarEstudiante">
                    <div class="mb-3">
                        <label class="block text-gray-700">Nombre</label>
                        <input
                            type="text"
                            v-model="form.nombre"
                            class="w-full px-3 py-2 border rounded"
                            required
                        />
                    </div>

                    <div class="mb-3">
                        <label class="block text-gray-700">Correo</label>
                        <input
                            type="email"
                            v-model="form.correo"
                            class="w-full px-3 py-2 border rounded"
                            required
                        />
                    </div>

                    <div class="mb-3">
                        <label class="block text-gray-700">Número de Control</label>
                        <input
                            type="text"
                            v-model="form.nctrl"
                            class="w-full px-3 py-2 border rounded"
                            required
                        />
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end mt-4">
                        <button
                            type="button"
                            @click="closeModal"
                            class="mr-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600"
                        >
                            Cancelar
                        </button>

                        <button
                            type="submit"
                            class="px-4 py-2 bg-green-300 text-black rounded hover:bg-green-600"
                        >
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

