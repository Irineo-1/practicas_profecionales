<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Practicas Profesionales</title>
    <!-- librerias de front-end -->
    <?php include('../componentes/vueKit.php'); ?>
</head>
<body>
    <div id="gestionPlantillas">
        <v-card class="mx-auto" :class="[`elevation-0`]" max-width="900">
            <v-layout>
                <v-app-bar color="#6a1c37">

                    <v-btn
                        color="white"
                        @click="goToAlumnos"
                        icon="mdi-account-edit"
                    >
                    </v-btn>

                    <v-btn
                        color="white"
                        @click="CerrarSesion"
                        icon="mdi-logout-variant"
                    >
                    </v-btn>

                    <v-spacer></v-spacer>

                    <div class="text-center">
                    <v-menu>
                        <template v-slot:activator="{ props }">
                            <v-btn
                                color="white"
                                v-bind="props"
                            >
                            {{ nombreMaestro }} - {{ puesto }} - {{ turno }}
                            </v-btn>
                        </template>
                    </v-menu>
                    </div>
                </v-app-bar>

                <v-main>
                    <v-container fluid>
                        <v-row dense>
                            <v-col>
                                <v-card class="mx-auto" :class="[`elevation-5`]">
                                    <v-card-text>
                                        <span
                                            style="font-weight: 600; font-size: 1.1rem;"
                                        >
                                            En este apartado se encuentran las plantillas "machote" en blanco utilizados para generarle
                                            a los alumnos en el proceso de practicas profesionales.
                                        </span>
                                        <br>
                                        <br>
                                        <span
                                            style="font-weight: 600; font-size: 1.1rem;"
                                        >
                                            Para poder ser editados por el sistema se usan expresiones diferentes dentro del documento. Ejemplo: #NOMBREINSTITUCION#.
                                            Favor de visualizar el documento y cambiar los apartados correspondientes antes de reemplazarlo para que el sistema funcione correctamente.
                                            El archivo tendrá que tener la extensión docx.
                                        </span>
                                        <br>
                                        <br>
                                        <v-alert
                                            v-if="showAlerta"
                                            closable
                                            title="Archivo reemplasado correctamente"
                                            type="success"
                                        ></v-alert>
                                        <v-list>
                                            <v-list-item>
                                                <v-list-item-title>Solicitud de practica profesional</v-list-item-title>
                                                <template v-slot:append>
                                                    <v-btn
                                                        icon="mdi-cloud-upload"
                                                        variant="tonal"
                                                        @click="uploadFile = true, fileToReplace = 'solicitud_practicas.docx'"
                                                        style="margin-right: 5px;"
                                                    ></v-btn>
                                                    <v-btn
                                                        icon="mdi-download-circle-outline"
                                                        variant="tonal"
                                                        @click="downloadDocument('solicitud_practicas.docx')"
                                                    ></v-btn>
                                                </template>
                                            </v-list-item>
                                            <v-list-item>
                                                <v-list-item-title>Carta de presentación</v-list-item-title>
                                                <template v-slot:append>
                                                    <v-btn
                                                        icon="mdi-cloud-upload"
                                                        variant="tonal"
                                                        @click="uploadFile = true, fileToReplace = 'carta_presentacion.docx'"
                                                        style="margin-right: 5px;"
                                                    ></v-btn>
                                                    <v-btn
                                                        icon="mdi-download-circle-outline"
                                                        variant="tonal"
                                                        @click="downloadDocument('carta_presentacion.docx')"
                                                    ></v-btn>
                                                </template>
                                            </v-list-item>
                                            <v-list-item>
                                                <v-list-item-title>Informe Mensual</v-list-item-title>
                                                <template v-slot:append>
                                                    <v-btn
                                                        icon="mdi-cloud-upload"
                                                        variant="tonal"
                                                        @click="uploadFile = true, fileToReplace = 'ppinforme.docx'"
                                                        style="margin-right: 5px;"
                                                    ></v-btn>
                                                    <v-btn
                                                        icon="mdi-download-circle-outline"
                                                        variant="tonal"
                                                        @click="downloadDocument('ppinforme.docx')"
                                                    ></v-btn>
                                                </template>
                                            </v-list-item>
                                            <v-list-item>
                                                <v-list-item-title>Acuerdo entre instituciones</v-list-item-title>
                                                <template v-slot:append>
                                                    <v-btn
                                                        icon="mdi-cloud-upload"
                                                        variant="tonal"
                                                        @click="uploadFile = true, fileToReplace = 'convenio.docx'"
                                                        style="margin-right: 5px;"
                                                    ></v-btn>
                                                    <v-btn
                                                        icon="mdi-download-circle-outline"
                                                        variant="tonal"
                                                        @click="downloadDocument('convenio.docx')"
                                                    ></v-btn>
                                                </template>
                                            </v-list-item>
                                        </v-list>
                                    </v-card-text>

                                    <v-dialog
                                    v-model="uploadFile"
                                    persistent
                                    width="auto"
                                    >
                                        <v-card>
                                            <v-card-title class="text-h5">
                                                Reemplasar documento
                                            </v-card-title>

                                            <v-card-text>
                                                <span class="text-caption text-grey">Solo PDF</span>
                                                <br>
                                                <br>
                                                <v-file-input
                                                    show-size
                                                    counter
                                                    density="compact"
                                                    accept=".docx"
                                                    v-model="archivo"
                                                    label="Click aqui para subir el documento"
                                                ></v-file-input>
                                            </v-card-text>
                                            
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    color="green-darken-1"
                                                    variant="text"
                                                    @click="uploadFile = false"
                                                >
                                                    Cancelar
                                                </v-btn>
                                                <v-btn
                                                    color="green-darken-1"
                                                    variant="text"
                                                    :disabled="( archivo.length < 1 ) ? true : false"
                                                    @click="reemplazarDocumento"
                                                >
                                                    Actualizar
                                                </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-main>
            </v-layout>
        </v-card>
    </div>

    <script type="module" src="../modulos/gestionPlantillas.js"></script>
</body>
</html>