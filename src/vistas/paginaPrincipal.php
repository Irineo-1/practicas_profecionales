<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Practicas Profesionales</title>
    <!-- librerias de front-end -->
    <?php include('src/componentes/vueKit.php'); ?>
    <!-- librerias de front-end -->
    <link rel="stylesheet" href="src/css/paginaPrincipal.css">
</head>
<body>
    <div id="paginaPrincipal">
        <v-card class="mx-auto" :class="[`elevation-0`]" max-width="900">
            <v-layout>
                <v-app-bar color="#6a1c37">

                    <v-spacer></v-spacer>

                    <div class="text-center">
                    <v-menu>
                        <template v-slot:activator="{ props }">
                            <v-btn
                                color="white"
                                v-bind="props"
                            >
                            {{ userName }}
                            <v-icon>mdi-chevron-down</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item value="1">
                                <template v-slot:prepend>
                                    <v-icon>mdi-account-circle</v-icon>
                                </template>
                                <v-list-item-title>Perfil</v-list-item-title>
                            </v-list-item>
                            <v-list-item value="2">
                                <template v-slot:prepend>
                                    <v-icon>mdi-account-off </v-icon>
                                </template>
                                
                                <v-list-item-title @click ="CerrarSesion">Cerrar sesión</v-list-item-title>
                                 

                            </v-list-item>
                        </v-list>
                    </v-menu>
                    </div>
                </v-app-bar>

                <v-main>
                    <v-container fluid>
                    <v-row dense>
                        <v-col>
                            <v-card class="mx-auto" :class="[`elevation-5`]">
                                <v-card-title class="text-h6 font-weight-regular justify-space-between">
                                <span style="margin-right: 10px;">{{tituloApartados[step]}}</span>
                                <v-avatar
                                    color="#6a1c37"
                                    size="30"
                                    v-text="step +1"
                                ></v-avatar>
                                </v-card-title>

                                <v-window v-model="step">
                                <v-window-item :value="0">

                                    <v-card
                                        title="¿Has realizado ya tu servicio social?"
                                    >
                                        <v-card-text>
                                            <v-row>
                                                <v-col
                                                    cols="12"
                                                    class="py-2"
                                                >
                                                    <v-btn-toggle
                                                    v-model="respuestaPrimerPregunta"
                                                    rounded="0"
                                                    color="#6a1c37"
                                                    group
                                                    >
                                                        <v-btn value="si">
                                                            Si
                                                        </v-btn>

                                                        <v-btn value="no">
                                                            No
                                                        </v-btn>
                                                    </v-btn-toggle>
                                                </v-col>
                                            </v-row>
                                            <br>
                                            <span
                                                v-show="respuestaPrimerPregunta == 'no'"
                                                style="font-weight: 600; color: #6a1c37"
                                            >
                                                No puedes realizar tus practicas profesionales si no tienes tu servicio
                                            </span>
                                        </v-card-text>

                                        <v-divider></v-divider>

                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn
                                                color="#6a1c37"
                                                variant="flat"
                                                @click="step ++"
                                                :disabled="(respuestaPrimerPregunta == 'no' || respuestaPrimerPregunta == '') ? true : false"
                                            >
                                                Siguiente
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>

                                </v-window-item>

                                <v-window-item :value="1">
                                    <v-card>
                                        <v-card-text>
                                            <span style="font-weight: 600; font-size: 1.1rem;">Subir constancia de termino</span>
                                            <br>
                                            <span class="text-caption text-grey">Solo imagenes o pdf</span>
                                            <br>
                                            <br>
                                            <v-file-input
                                                show-size
                                                counter
                                                density="compact"
                                                accept="image/*,.pdf"
                                                v-model="constanciaFile"
                                                label="Click aqui para subir el documento"
                                            ></v-file-input>
                                        </v-card-text>
                                        
                                        <v-divider></v-divider>

                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn
                                                color="#6a1c37"
                                                variant="flat"
                                                @click="subirConstancia"
                                                :disabled="( constanciaFile.length < 1 ) ? true : false"
                                            >
                                                Siguiente
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-window-item>

                                <v-window-item :value="2">
                                    <v-card>
                                        <div>
                                            <v-container>
                                                <v-row>
                                                    <v-col cols="12" xs="1" sm="6">
                                                        <v-text-field
                                                        variant="solo"
                                                        label="Buscar insitucion"
                                                        density="compact"
                                                        prepend-inner-icon="mdi-magnify"
                                                        v-model="buscarEmpresa"
                                                        >
                                                        </v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" xs="1" sm="6" class="d-flex justify-end">
                                                        <v-btn @click="test">Otra insitucion</v-btn>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </div>
                                        <div
                                            class="container-list-instituciones"
                                        >
                                            <v-list-item
                                                v-for="instituto, i in resolveInstituciones"
                                                :key="i"
                                                :title="instituto.nombre_empresa"
                                                :subtitle="instituto.entidad_federativa + ' - ' + instituto.tipo_empresa + ' - ' + instituto.tipo_institucion"
                                                class="style-item-list"
                                            >
                                                <template v-slot:append>
                                                    <v-btn
                                                        color="#6a1c37"
                                                        @click="seleccionarEmpresa(instituto.id)"
                                                    >
                                                    Seleccionar
                                                    </v-btn>
                                                </template>
                                            </v-list-item>
                                        </div>
                                    </v-card>
                                </v-window-item>
                                </v-window>
                            </v-card>
                        </v-col>
                    </v-row>
                    </v-container>
                </v-main>
            </v-layout>
        </v-card>
    </div>

    <script type="module" src="src/modulos/paginaPrincipal.js"></script>
</body>
</html>