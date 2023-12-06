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
                    
                    <v-btn
                        color="white"
                        v-if="step == 5"
                        @click="goToInformes"
                    >
                        informes
                    </v-btn>
                    
                    <v-btn
                        color="white"
                        icon="mdi-file-cloud"
                        @click="goToDocumentos"
                    >
                    </v-btn>
                    
                    <v-btn
                        color="white"
                        @click ="CerrarSesion"
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
                            {{ userName }}
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
                                                v-model="archivo"
                                                label="Click aqui para subir el documento"
                                            ></v-file-input>
                                        </v-card-text>
                                        
                                        <v-divider></v-divider>

                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn
                                                color="#6a1c37"
                                                variant="flat"
                                                @click="subirArchivo('constancia_termino')"
                                                :disabled="( archivo.length < 1 ) ? true : false"
                                            >
                                                Siguiente
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-window-item>

                                <v-window-item :value="2">
                                    <v-card>
                                        <v-card-text>
                                            Presiona el boton <v-btn color="#6a1c37" size="x-small" icon="mdi-download"></v-btn> para descargar la solicitud de practicas
                                        </v-card-text>
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
                                                        <v-btn @click="showFormAddInstitucion = true">Otra insitucion</v-btn>
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
                                                :subtitle="instituto.entidad_federativa + ' - ' + instituto.direccion"
                                                class="style-item-list"
                                            >
                                                <template v-slot:append>
                                                    <v-btn
                                                        color="#6a1c37"
                                                        @click="seleccionarEmpresa(instituto.id)"
                                                        icon="mdi-download"
                                                    >
                                                    </v-btn>
                                                </template>
                                            </v-list-item>
                                        </div>
                                    </v-card>
                                </v-window-item>

                                <v-window-item :value="3">
                                    <v-card v-if="statusSolicitud == 3">
                                        <v-card-text>
                                            <span style="font-weight: 600; font-size: 1.1rem;">Subir solicitud firmada</span>
                                            <br>
                                            <span class="text-caption text-grey">Solo PDF</span>
                                            <br>
                                            <br>
                                            <v-file-input
                                                show-size
                                                counter
                                                density="compact"
                                                accept=".pdf"
                                                v-model="archivo"
                                                label="Click aqui para subir el documento"
                                            ></v-file-input>
                                        </v-card-text>
                                        
                                        <v-divider></v-divider>

                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn
                                                color="#6a1c37"
                                                @click="step--"
                                            >
                                                Seleccionar otra empresa
                                            </v-btn>
                                            <v-btn
                                                color="#6a1c37"
                                                variant="flat"
                                                @click="subirArchivo('solicitud')"
                                                :disabled="( archivo.length < 1 ) ? true : false"
                                            >
                                                Subir
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                    <v-card v-else>
                                        <v-card-text>
                                            <v-alert
                                                :title="(statusSolicitud == 1) ? 'En espera' : (statusSolicitud == 0) ? 'Rechasado' : (statusSolicitud == 2) ? 'Aceptado' : ''"
                                                variant="outlined"
                                                border="bottom"
                                                :text="mensajeStatusDocumentos"
                                                :type="(statusSolicitud == 1) ? 'info' : (statusSolicitud == 0) ? 'error' : (statusSolicitud == 2) ? 'success' : ''"
                                            ></v-alert>
                                        </v-card-text>
                                        
                                        <v-divider></v-divider>

                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn
                                                v-if="statusSolicitud == 0"
                                                color="#6a1c37"
                                                variant="flat"
                                                @click="cleanProcess('solicitud')"
                                            >
                                                Volver a subir el documento
                                            </v-btn>
                                            <v-btn
                                                color="#6a1c37"
                                                variant="flat"
                                                @click="updateStep"
                                                :disabled="( statusSolicitud == 1 || statusSolicitud == 0 ) ? true : false"
                                            >
                                                siguiente
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-window-item>

                                <v-window-item :value="4">
                                    <v-card v-if="statusCartaAceptacion == 3">
                                        <v-card-text>
                                            <span style="font-weight: 600; font-size: 1.1rem;">1.- Descargar la carta de presentación y firmarla</span>
                                            <br>
                                            <v-container>
                                                <v-row>
                                                    <v-col>
                                                        <h3>Inicio: </h3>
                                                        <input type="date" v-model="fechaInicio">
                                                    </v-col>
                                                    <v-col>
                                                        <v-select
                                                        label="Selecciona un director"
                                                        v-model="directorAcargo"
                                                        :items="directores"
                                                        item-title="nombre"
                                                        item-value="nombre"
                                                        variant="underlined"
                                                        ></v-select>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                            <v-btn
                                                append-icon="mdi-download"
                                                @click="descargarCartaPrecentacion"
                                                :disabled="( fechaInicio.trim() == '' || directorAcargo.trim() == '' ) ? true : false"
                                            >
                                                Descargar carta de presentación
                                            </v-btn>
                                            <br>
                                            <br>
                                            <span style="font-weight: 600; font-size: 1.1rem;">2.- Subir carta de aceptación firmada</span>
                                            <br>
                                            <span class="text-caption text-grey">Solo PDF</span>
                                            <br>
                                            <br>
                                            <v-file-input
                                                show-size
                                                counter
                                                density="compact"
                                                accept=".pdf"
                                                v-model="archivo"
                                                label="Click aqui para subir el documento"
                                            ></v-file-input>
                                        </v-card-text>
                                        
                                        <v-divider></v-divider>

                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn
                                                color="#6a1c37"
                                                variant="flat"
                                                @click="subirArchivo('carta_aceptacion')"
                                                :disabled="( archivo.length < 1 ) ? true : false"
                                            >
                                                Siguiente
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                    <v-card v-else>
                                        <v-card-text>
                                            <v-alert
                                                :title="(statusCartaAceptacion == 1) ? 'En espera' : (statusCartaAceptacion == 0) ? 'Rechasado' : (statusCartaAceptacion == 2) ? 'Aceptado' : ''"
                                                variant="outlined"
                                                border="bottom"
                                                :text="mensajeStatusDocumentos"
                                                :type="(statusCartaAceptacion == 1) ? 'info' : (statusCartaAceptacion == 0) ? 'error' : (statusCartaAceptacion == 2) ? 'success' : ''"
                                            ></v-alert>
                                        </v-card-text>
                                        
                                        <v-divider></v-divider>

                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn
                                                v-if="statusCartaAceptacion == 0"
                                                color="#6a1c37"
                                                variant="flat"
                                                @click="cleanProcess('carta_aceptacion')"
                                            >
                                                Volver a subir el documento
                                            </v-btn>
                                            <v-btn
                                                color="#6a1c37"
                                                variant="flat"
                                                @click="updateStep"
                                                :disabled="( statusCartaAceptacion == 1 || statusCartaAceptacion == 0 ) ? true : false"
                                            >
                                                siguiente
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-window-item>

                                <v-window-item :value="5">
                                    <v-card>
                                        <v-card-text>
                                            <span style="font-weight: 600; font-size: 1.1rem;">1.- Puedes ir a la parte de 'INFORMES' para que subas los informes a su debido tiempo.</span>
                                            <br>
                                            <br>
                                            <span style="font-weight: 600; font-size: 1.1rem;">2.- Ahí mismo podrás descargar la plantilla para los informes.</span>
                                            <br>
                                            <br>
                                            <span style="font-weight: 600; font-size: 1.1rem;">3.- En el icono de <v-icon>mdi-file-cloud</v-icon> puedes ver los documentos ya subidos.</span>
                                            <br>
                                            <br>
                                            <span style="font-weight: 600; font-size: 1.1rem;">4.- En el icono de <v-icon>mdi-logout-variant</v-icon> puedes cerrar sesión.</span>
                                        </v-card-text>
                                    </v-card>
                                </v-window-item>
                                </v-window>
                            </v-card>
                        </v-col>
                    </v-row>
                    </v-container>
                </v-main>
            </v-layout>

            <v-dialog
            v-model="showFormAddInstitucion"
            persistent
            width="auto"
            >
                <v-card>
                    <v-card-title class="text-h5">
                        Agregar institucion
                    </v-card-title>

                    <v-card-text>
                        <v-select
                        label="Selecciona un director"
                        v-model="directorAcargo"
                        :items="directores"
                        item-title="nombre"
                        item-value="nombre"
                        variant="underlined"
                        ></v-select>
                        <v-text-field label="Nombre de la institución" variant="underlined" v-model="adNombreInstitucion"></v-text-field>
                        <v-text-field label="Nombre del titular" variant="underlined" v-model="adNombreTitular"></v-text-field>
                        <v-text-field label="Puesto del titular" variant="underlined" v-model="adPuestoTitular"></v-text-field>
                        <v-text-field label="RFC" variant="underlined" v-model="adRfc"></v-text-field>
                        <v-text-field label="Dirección" variant="underlined" v-model="adDireccion"></v-text-field>
                        <v-text-field label="Telefono" type="number" variant="underlined" v-model="adTelefono"></v-text-field>
                        <v-text-field label="Correo" :rules="emailRules" variant="underlined" v-model="adCorreo"></v-text-field>
                        <v-text-field label="Nombre del testigo" variant="underlined" v-model="adNombreTestigo"></v-text-field>
                        <v-text-field label="Puesto del testigo" variant="underlined" v-model="adPuestoTestigo"></v-text-field>
                        <v-text-field label="Entidad federativa" variant="underlined" v-model="adEntidadFederativa"></v-text-field>
                        <v-text-field label="Clave" variant="underlined" v-model="adClaveCentro"></v-text-field>
                        <v-text-field label="Tipo de institucion" variant="underlined" v-model="adTipoInstitucion"></v-text-field>
                    </v-card-text>
                    
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="green-darken-1"
                            variant="text"
                            @click="showFormAddInstitucion = false"
                        >
                            Cancelar
                        </v-btn>
                        <v-btn
                            color="green-darken-1"
                            variant="text"
                            @click="generarConvenio"
                        >
                            Generar convenio
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-card>
    </div>

    <script type="module" src="src/modulos/paginaPrincipal.js"></script>
</body>
</html>