import { AbilityBuilder, Ability } from "@casl/ability";

const { can, rules } =  new AbilityBuilder(Ability);
const loggedIn = localStorage.getItem('permissions')
const userData = JSON.parse(loggedIn);
var  permissions = null;
if(userData){
    permissions = userData;
}
can(permissions, 'all');

console.log(permissions)

let ability = new Ability(rules);
export {ability };
