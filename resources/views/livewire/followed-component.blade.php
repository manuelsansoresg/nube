<div>
    <a class="link-profile" data-toggle="modal" data-target="#listFollowed">
        <span class="text-muted font-weight-bold"> {{ $myFollowed }}   <span class="text-muted font-weight-normal">Seguidos</span> </span>
    </a>
    <div class="col-12">

    </div>

    <!-- modal followed(seguidos)-->
    <div class="modal fade" id="listFollowed" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <!-- Change class .modal-sm to change the size of the modal -->
        <div class="modal-dialog" role="document">
            <div class="modal-content h-600">
                <div class="modal-header">
                    <h4 class="modal-title w-100 text-center" id="myModalLabel">
                        Seguidos
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modalListUser scroll-modal" id="contentlistFollowed">

                    <div v-if="isShow">
                        <div class="container">
                            <div class="row mt-5 d-none">
                                <div class="col-4 col-md-6 offset-1 offset-md-1"><span class="font-weight-bold text-muted small">Usuario</span></div>
                                <div class="col-1 offset-1 offset-md-0 col-md-1"> <i class="fas fa-heart heart-small text-danger heart"></i></div>

                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="row mt-5 listado py-3" v-for="(user, key) in users">
                                <div class="col-3 col-md-3 ml-md-n1 offset-0 offset-md-1">
                                    <a :href="'/usuario/'+user.id">
                                     <img :src="path+'/' + user.id + '/thumb-' + user.photo " alt="Profiler" class="rounded-circle shadow img-fluid">
                                    </a>
                                 
                                </div>
                                <div class="col-3 col-md-3 align-self-center"> <span class="small"> {{-- {{ user.username }} --}}  </span> </div>

                                <div class="col-6 offset-0 offset-md-0 col-md-5 align-self-center">
                                    <div class="row">
                                        <div class="col-7">
                                            <span class="small">{{-- {{ nFormatter(user.heart) }} --}}</span>
                                            <i class="fas fa-heart heart-small text-danger ml-2"></i>
                                        </div>
                                        
                                        <div v-if="user_id != null" class="col-5 d-inline text-left">
                                            <button :disabled="!btnBlock" v-if="user_id === user.id" type="button" class="btn btn-outline-primary btn-rounded ml-2 btn-rounded shadow px-2 px-md-3 btn-sm">Yo</button>
                                            <button :disabled="!btnBlock" v-else-if="user.btn == user_id" @click="{{-- unfollow(user.id) --}}" type="button" class="btn btn-primary btn-rounded ml-2 btn-rounded shadow px-1 px-md-2 btn-sm btn-follow">Siguiendo</button>
                                            <button :disabled="!btnBlock" @click="{{-- follow(user.id) --}}" v-else type="button" class="btn btn-outline-primary btn-rounded ml-2 btn-rounded shadow px-2 px-md-3 btn-sm">Seguir</button>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="isSpiner" >
                            <div class="col-12 text-center mt-5">
                                <i class="fas fa-spinner fa-spin text-success"></i>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center"> <span class="lead">No tienes seguidores</span> </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- /modal followed(seguidos)-->