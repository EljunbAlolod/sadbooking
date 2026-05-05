# Boarding Hub – Database Schema
## Technical Documentation & Transparency

The following documentation outlines the core database structure of the Boarding Hub platform.

---

### 1. Users Table (`users`)
Stores core identity and role information.
| Field | Type | Description |
| :--- | :--- | :--- |
| `id` | BigInt (PK) | Unique identifier for the user. |
| `name` | String | Full name of the user. |
| `email` | String (Unique) | Primary login and contact email. |
| `role` | Enum | `super_admin`, `landlord`, or `tenant`. |
| `profile_photo_path` | String (Nullable) | Path to the user's avatar. |

### 2. Boarding Houses Table (`boarding_houses`)
Primary property listings managed by Landlords.
| Field | Type | Description |
| :--- | :--- | :--- |
| `id` | BigInt (PK) | Unique identifier for the property. |
| `landlord_id` | BigInt (FK) | Reference to the owner in the `users` table. |
| `title` | String | Name of the boarding house. |
| `street`, `barangay`, `city`, `province` | String | Structured address fields. |
| `photo_path` | String | Main cover photo of the house. |

### 3. Rooms Table (`rooms`)
Individual units within a Boarding House.
| Field | Type | Description |
| :--- | :--- | :--- |
| `id` | BigInt (PK) | Unique identifier for the room. |
| `boarding_house_id` | BigInt (FK) | Reference to the parent property. |
| `room_number` | String | Label for the room (e.g., "Room 101"). |
| `capacity` | Integer | Maximum number of occupants allowed. |
| `current_occupants` | Integer | Live count of tenants currently staying. |
| `monthly_rate` | Decimal (10,2) | Cost of stay per month. |
| `status` | Enum | `available` or `full`. |

### 4. Reservations Table (`reservations`)
Tracks the booking requests and active stays.
| Field | Type | Description |
| :--- | :--- | :--- |
| `id` | BigInt (PK) | Unique identifier for the reservation. |
| `tenant_id` | BigInt (FK) | Reference to the requester in the `users` table. |
| `room_id` | BigInt (FK) | Reference to the target room. |
| `start_date`, `end_date` | Date | The intended period of stay. |
| `status` | Enum | `pending`, `approved`, `active`, `completed`, `cancelled`, `rejected`. |

### 5. Amenities & Photos
- **Amenities**: Many-to-many relationship with both Boarding Houses and Rooms via pivot tables.
- **Photos**: Multiple photos can be attached to both Boarding Houses and Rooms with a `sort_order` field.

---

## ⚖️ Terms and Conditions
### Last Updated: May 6, 2026

By accessing or using the **Boarding Hub** platform, you agree to comply with and be bound by the following Terms and Conditions.

1. **Description of Service**: Boarding Hub is a property management and discovery platform connecting Landlords and Tenants.
2. **User Roles**: Tenants are responsible for accurate stay dates; Landlords for property accuracy.
3. **Reservations**: Requests are not binding until approved by the Landlord.
4. **Payments**: All financial transactions are settled directly between users; Boarding Hub does not process payments.
5. **Liability**: Boarding Hub is not liable for disputes arising between users.

---
*End of Document*
